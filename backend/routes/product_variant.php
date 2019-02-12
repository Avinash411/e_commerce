<?php 
///NO need this I think
//create product variant page

Route::get('/create_product_variant','ProductVariantController@create')->name('get:ProductVariantController:create');

//storing information

Route::post('/create_product_variant','ProductVariantController@store')->name('post:ProductVariantController:store');

//show all product variant 

Route::get('/product_variant/show','ProductVariantController@show')->name('get:ProductVariantController:show');

//edit part

Route::get('/product_variant/edit','ProductVariantController@edit')->name('get:ProductVariantController:edit');

 //user can it the filled data and submit then that goto update databse and redirect it on show all data page that is /Variants/show

Route::post('/product_variant/show/edit','ProductVariantController@update')->name('post:ProductVariantController:update');

//soft delete data is here

Route::post('/product_variant/show/delete','ProductVariantController@destroy')->name('post:ProductVariantController:destroy');