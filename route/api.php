<?php

use Core\Route;

Route::group(['prefix'=>'track'],function (){
    Route::run('{id}','track@getTrack');
    Route::run('getTracks','track@getTracks');
    Route::run('topTracks/{id}','track@topTracks');
    Route::run('getFavouriteTracks','track@getFavouriteTracks');
    Route::run('soundbot','track@callbot');
    Route::run('favourites','track@getFavouriteTracks');
});

Route::group(['prefix'=>'genre'],function (){
    Route::run('{id}','genre@route');
    Route::run(null,'genre@index');
});

Route::group(['prefix'=>'auth'],function (){
    Route::run('register','auth@register', 'POST');
    Route::run('login','auth@login', 'POST');
});

Route::group(['prefix'=>'favourite'],function (){
    Route::run('','track@favouriteTrack', 'POST');
    Route::run('','track@deleteFavouriteTrack', 'DELETE');
});

Route::run('image/{hashed_name}','image@returnImg');
Route::run('search','track@search', 'POST');
Route::run('youtube','youtube@youtubeSearch');
Route::run('bot','bot@index','POST');