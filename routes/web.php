<?php

// Home
Route::get('/', 'PagesController@home')->middleware('auth');
Route::get('home', 'PagesController@home')->middleware('auth');

// Threads
Route::group(['prefix' => 'threads', 'middleware' => 'auth'], function () {
    // Show
    Route::get('/', 'ThreadsController@index');
    Route::get('{id}/{slug}', 'ThreadsController@show');

    // Create
    Route::get('create', 'ThreadsController@create');
    Route::post('/', 'ThreadsController@store');

    // Edit
    Route::get('{id}/{slug}/edit', 'ThreadsController@edit');
    Route::put('{id}/{slug}', 'ThreadsController@update');
    Route::patch('{id}/{slug}', 'ThreadsController@update');

    // Delete
    Route::delete('{id}/{slug}', 'ThreadsController@destroy');
});

// Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'Auth\AuthController@showLogin')->middleware('guest');
    Route::get('facebook', 'Auth\AuthController@login')->middleware('guest');
    Route::get('logout', 'Auth\AuthController@logout')->middleware('auth');
});
