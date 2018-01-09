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

Route::get('/products', function()
{
	return view('welcome');
});
Route::get('/list','itemController@index');
Route::post('/list','itemController@store');
Route::post('/delete','itemController@delete');
Route::post('/update','itemController@update');