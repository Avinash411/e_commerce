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
//this is home page 
Route::get('/', function () {
    return view('welcome');
});
//this for when user click to login or register
Route::get('/test', function () {
    return view('welcome');
});

//Route::get('/create_brand','BrandController@create');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/get_password',function(){

	echo Hash::make('temp123');


});
