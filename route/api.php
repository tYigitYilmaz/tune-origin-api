<?php

use Core\Route;

Route::run('/genre','genre@index');
Route::run('/track/getTracks','track@getTracks');
Route::run('/track/getFavouriteTracks','track@getFavouriteTracks');
Route::run('/track/soundbot','track@callbot');
Route::run('/track/genre/{id}','genre@route');