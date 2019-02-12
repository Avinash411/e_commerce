<?php 

// create a page for new product entry

Route::get('/create_product','ProductController@create')->name('get:ProductController:create');

//storing product page entry

Route::post('/create_product','ProductController@store')->name('post:ProductController:store');

//displaying details of he product

Route::get('/product/show','ProductController@show')->name('get:ProductController:show');

//edit existing data

Route::get('/product/edit','ProductController@edit')->name('get:ProductController:edit');

//removing product image 

Route::post('/product/remove','ProductController@remove_image_edit_process')->name('post:ProductController:remove_image_edit_process');

//remove variant image

Route::post('/product/variant_image_remove','ProductController@variant_image_remove')->name('post:ProductController:variant_image_remove');

//displaying associated variant value

Route::post('/product/variants','ProductController@variant_value')->name('post:ProductController:variant_value');

//creating combination of array

Route::post('/product/combination','ProductController@create_combination')->name('post:ProductController:create_combination');

//addind new variants of edit page 

Route::post('/product/new_add','ProductController@adding_new_variants')->name('post:ProductController:adding_new_variants');

//deleting existing variant 

Route::post('/product/delete_variant','ProductController@delete_variant')->name('post:ProductController:delete_variant');


//restore data
Route::get('/product/restore','ProductController@DeletedDataShow')->name('get:ProductController:DeletedDataShow');
//storing deleted data 
Route::post('/product/restore','ProductController@DeletedDataStore')->name('post:ProductController:DeletedDataStore');



//updating product details with all details

Route::post('/product/show/edit','ProductController@update')->name('post:ProductController:update');

//delete product with all details

Route::post('/product/show/delete','ProductController@destroy')->name('post:ProductController:destroy');

