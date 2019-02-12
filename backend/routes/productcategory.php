<?php

//this for create a category form then user will filled it.

Route::get('/category','ProductsCategoryController@create')->name('get:ProductsCategoryController:create');

//take filled category form by post method to store in database redirect of category location like on upper one 

Route::post('/category','ProductsCategoryController@store')->name('post:ProductsCategoryController:store');


//restore data
Route::get('/restore','ProductsCategoryController@DeletedDataShow')->name('get:ProductsCategoryController:DeletedDataShow');
//storing deleted data 
Route::post('/restore','ProductsCategoryController@DeletedDataStore')->name('post:ProductsCategoryController:DeletedDataStore');

//its show all data that user filled in category form with table and there is option to edit and delete

Route::get('/category/show','ProductsCategoryController@show')->name('get:ProductsCategoryController:show');

//when user click to edit then go to this loctation display a form with filled data 

Route::get('/category/edit/{id}','ProductsCategoryController@edit')->name('get:ProductsCategoryController:edit');



 //user can it the filled data and submit then that goto update databse and redirect it on show all data page that is /category/show

Route::post('/category/update','ProductsCategoryController@update')->name('post:ProductsCategoryController:update');


//soft delete data is here

Route::post('/category/delete','ProductsCategoryController@destroy')->name('post:ProductsCategoryController:destroy');

