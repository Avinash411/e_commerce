<?php 

//create all variation 

Route::get('/create_variation','VariantController@create')->name('get:VariantController:create');

//storing date

Route::post('/create_variation','VariantController@store')->name('post:VariantController:store');

//show all part

Route::get('/variation/show','VariantController@show')->name('get:VariantController:show');
//edit part

Route::get('/variation/edit/{id}','VariantController@edit')->name('get:VariantController:edit');

 //user can it the filled data and submit then that goto update databse and redirect it on show all data page that is /Variants/show

Route::post('/variation/edit','VariantController@update')->name('post:VariantController:update');

//soft delete data is here

Route::post('/variation/delete','VariantController@destroy')->name('post:VariantController:destroy');

//show all deleted data
Route::get('/variation/restore','VariantController@DeleteData')->name('get:VariantController:DeleteData');
//restoring data
Route::post('/variation/restore','VariantController@RestoreData')->name('post:VariantController:RestoreData');