<?php
use App\Support\Route;
use App\Http\Middleware\JWTMiddleware as JWT;

//these urls does not require authentication
Route::post('/users/store', 'UserController@store');
Route::post('/users/token', 'UserController@token');
Route::get('/unauthorized', 'UserController@unauthorized');


//these urls require authentication
Route::get('/stock', 'StooqController@getStock')->add(JWT::class);
Route::get('/history', 'StooqController@getHistory')->add(JWT::class);
