<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/register', 'API\AuthController@register')->name('api_login');
    Route::post('/login', 'API\AuthController@login')->name('api_register');
});
Route::group(['middleware' => 'auth:api', 'namespace' => 'API'], function ($app) use ($router) {
    $app->resource('product_categories', 'ProductCategoryController');
    $app->post('/logout', 'AuthController@logout')->name('api_logout');
});
