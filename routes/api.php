<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', 'App\Http\Controllers\Api\ProductController@index')->name('product.index');
Route::post('/products', 'App\Http\Controllers\Api\ProductController@store')->name('product.store');
Route::get('/products/{id}', 'App\Http\Controllers\Api\ProductController@show')->name('product.show');
Route::put('/products/{id}', 'App\Http\Controllers\Api\ProductController@update')->name('product.update');
Route::delete('/products/{id}', 'App\Http\Controllers\Api\ProductController@destroy')->name('product.destroy');
Route::get('/search/namecategory/{name}/{category}', 'App\Http\Controllers\Api\ProductController@searchNameCategory')->name('product.searchNameCategory');
Route::get('/search/namecategory/{category}', 'App\Http\Controllers\Api\ProductController@searchCategory')->name('product.searchCategory');
Route::get('/search/withimage', 'App\Http\Controllers\Api\ProductController@searchProductWithImage')->name('product.searchProductWithImage');
Route::get('/search/withoutimage', 'App\Http\Controllers\Api\ProductController@searchProductWithoutImage')->name('product.searchProductWithoutImage');