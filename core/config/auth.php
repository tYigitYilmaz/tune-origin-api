<?php
error_reporting(E_ALL);

date_default_timezone_set('Europe/Istanbul');


$core_var = [
    "key" => getenv('KEY'),
    "iss" => getenv('ISS'),
    "aud" => getenv('AUD'),
    "iat" => getenv('IAT'),
    "nbf" => getenv('NBF'),
    "api" => getenv('API'),
];
?>