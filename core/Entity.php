<?php
//include_once(BASE_DIR."core/db.php");
//include_once(BASE_DIR."model/response.p
include_once(dirname(__DIR__)."/core/db.php");
include_once(dirname(__DIR__)."/model/response.php");

class Entity
{
    private static $table_name;
    private static $query_string = [
        "where" =>[],
        "order" =>[],
        "take" =>[]
    ];
    private static $where_string = "";
    private static $order_string = "";
    private static $taken_string = "";
    private static $final_query = "";

    public function __construct($table_name)
    {
        try {
           $this->table_name = $table_name;
           $writeDB = DB::connectWriteDB();
           return $writeDB;

        } catch (PDOException $ex) {
            // log connection error for troubleshooting and return a json error response
            error_log("Connection Error: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database connection error");
            $response->send();
            exit;
        }
    }

    public function getData($table_name, $id = null){
        $writeDB = DB::connectWriteDB();
        if (isset($id)) {
            $query = $writeDB->query("SELECT * FROM $table_name WHERE id = '$id' ORDER BY id ASC");
        } else {
            $query = $writeDB->query("SELECT * FROM $table_name ORDER BY id ASC ");
        }
        $rowCount = $query->rowCount();
        if ($rowCount >= 1) {
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $result = $query->fetchAll();
        } else {
            $result = 0;
        }
        return $result;
    }

    function listFields($table_name)
    {
        $writeDB = DB::connectWriteDB();
        $query = $writeDB->query("DESCRIBE $table_name");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();
        return $result;
    }

    function editData($table_name, $param, $id)
    {
        $writeDB = DB::connectWriteDB();
        foreach ($param as $key => $value) {
            $query = $writeDB->query("UPDATE $table_name SET $key = '$value' WHERE id = '$id'");
        }
    }

    function listTables()
    {
        $writeDB = DB::connectWriteDB();
        $query = $writeDB->query("SHOW TABLES");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();
        return $result;
    }

    function createData($table_name, $param)
    {
        $writeDB = DB::connectWriteDB();
        $table_fields = "";
        $params = "";

        foreach ($param as $key => $value) {
            if ($key == "insert_values"||$key == "tableName") {
                continue;
            }
            $table_fields .= $key . ',';
            $params .= '"' . $value . '",';
        }
        $table_fields = rtrim($table_fields, ',');
        $params = rtrim($params, ',');
        $query = "INSERT IGNORE INTO $table_name ($table_fields) VALUES ($params)";
        $writeDB->query($query);
    }

    function deleteDAta($table_name, $id)
    {
        $writeDB = DB::connectWriteDB();
        $query = $writeDB->query("DELETE FROM $table_name WHERE id = '$id'");
        $rowCount = $query->rowCount();
        return $rowCount;
    }


    public function where($column, $value, $operator=null)
    {
        isset($operator) == null ? $operator="=":true;
        $this->where_string .= $column.$operator.'"'.$value.'"'."| ";
        return $this;
    }

    public function orderBy($value,$ASCorDEC="ASC"){
        strtoupper($ASCorDEC);
        $this->order_string =" ORDER BY $value $ASCorDEC";
        $this->query_string["order"] =$this->order_string;
        return $this;
    }

    public function find($id){
        $this->where_string .="ID=".'"'.$id.'"'."| ";
        $this->query_string["where"] = $this->where_string;
        return $this;
    }

    public function take($startFrom, $count){
        $this->taken_string = " LIMIT $startFrom, $count";
        $this->query_string["take"] = $this->taken_string;
        return $this;
    }

    public function first(){
        $taken_string = " LIMIT 1";
        $this->query_string["take"] =$this->taken_string;
        return $this;
    }

    public function stringOp(){
        $arr = explode("| ",$this->where_string);
        $len = count($arr);
        unset($arr[$len-1]);
        $len = count($arr);
        $this->query_string["where"] ="";
        for ($i=0;$i<($len);$i++){
            if ($this->query_string["where"]==""){
                $this->query_string["where"] .= 'WHERE '.$arr[$i].' ';
            }else{
                $this->query_string["where"] .= 'AND '.$arr[$i].' ';
            }
        }
        $this->query_string["where"] =trim($this->query_string["where"]);
        $this->final_query = "SELECT * FROM `$this->table_name` ".(!empty($this->query_string["where"]) ? $this->query_string["where"] : "")
        .(!empty($this->query_string["order"]) ? $this->query_string["order"] : "").(!empty($this->query_string["take"]) ? $this->query_string["take"] : "");
    }

    public function get(){
        $writeDB = DB::connectWriteDB();
        $this->stringOp();
        $query = $writeDB->query(strval($this->final_query));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();
        return $result;
    }
}