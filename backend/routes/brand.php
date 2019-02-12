<?php

//this for create a brand form then user will filled it.

Route::get('/brand/create','BrandController@create')->name('get:BrandController:create');

//take filled brand form by post method to store in database redirect of brand location like on upper one 

Route::post('/brand/create','BrandController@store')->name('post:BrandController:store');

//its show all data that user filled in brand form with table and there is option to edit and delete

Route::get('/brand/show','BrandController@show')->name('get:BrandController:show');

//when user click to edit then go to this loctation display a form with filled data 

Route::get('/brand/edit/{id}','BrandController@edit')->name('get:BrandController:edit');

 //user can it the filled data and submit then that goto update databse and redirect it on show all data page that is /brand/show

Route::post('/brand/update','BrandController@update')->name('post:BrandController:update');

//soft delete data is here

Route::post('/brand/delete','BrandController@destroy')->name('post:BrandController:destroy');

//restore data
Route::get('/brand/restore','BrandController@DeletedDataShow')->name('get:BrandController:DeletedDataShow');
//storing deleted data 
Route::post('/brand/restore','BrandController@DeletedDataStore')->name('post:BrandController:DeletedDataStore');
