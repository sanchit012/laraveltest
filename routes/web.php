<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('add_product',['as'=>'add_product','uses'=>'HomeController@AddProduct']);
Route::get('list_product',['as'=>'list_product','uses'=>'HomeController@ListProduct']);
Route::get('edit_product/{id?}',['as'=>'edit_product','uses'=>'HomeController@EditProduct']);
Route::post('update_product',['as'=>'update_product','uses'=>'HomeController@UpdateProduct']);
Route::post('get_product_data',['as'=>'get_product_data','uses'=>'HomeController@GetProductData']);
Route::post('del_product_image',['as'=>'del_product_image','uses'=>'HomeController@DelProductImage']);
