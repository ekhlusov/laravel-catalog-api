<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::resource('products', 'ProductController');
    Route::resource('categories', 'CategoryController');
});

Route::get('products', 'ProductController@all');

Route::get('category/{id}', 'CategoryController@getProductsById');
Route::get('category/all', 'CategoryController@all');
