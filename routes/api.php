<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

Route::get('products/all', 'ProductController@all');
Route::get('categories/all', 'CategoryController@all');
Route::get('category/{id}', 'CategoryController@getProductsByCategoryId');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::resource('products', 'ProductController');
    Route::resource('categories', 'CategoryController');
});
