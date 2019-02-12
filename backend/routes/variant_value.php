<?php

//create variantion (variant value) value

Route::get('/create_value','VariantValueController@create')->name('get:VariantValueController:create');

//storing information

Route::post('/create_value','VariantValueController@store')->name('post:VariantValueController:store');

//show all data 

Route::get('/value/show','VariantValueController@show')->name('get:VariantValueController:show');

//edit part

Route::get('/value/edit/{id}','VariantValueController@edit')->name('get:VariantValueController:edit');


 //user can it the filled data and submit then that goto update databse and redirect it on show all data page that is /Variants/show

Route::post('/value/update','VariantValueController@update')->name('post:VariantValueController:update');

//soft delete data is here

Route::post('/value/delete','VariantValueController@destroy')->name('post:VariantValueController:destroy');

//show all deleted data
Route::get('/value/restore','VariantValueController@DeleteData')->name('get:VariantValueController:DeleteData');
//restoring data
Route::post('/value/restore','VariantValueController@RestoreData')->name('post:VariantValueController:RestoreData');
//get a particular category of all variants name for option
Route::post('/value/variantOfCategory','VariantValueController@allVariantOfCategory')->name('post:VariantValueController:allVariantOfCategory');