<?php

//create page of product offer
  Route::get('/product_offer','ProductOfferController@create')->name('get:ProductOfferController:create');

  //storing information

  Route::post('/product_offer','ProductOfferController@store')->name('post:ProductOfferController:store');

  //all offer product
  
  Route::get('/product_offer/show','ProductOfferController@show')->name('get:ProductOfferController:show');

  //edit part

  Route::get('/product_offer/edit','ProductOfferController@edit')->name('get:ProductOfferController:edit');

  //updating part

  Route::post('/product_offer/edit','ProductOfferController@update')->name('post:ProductOfferController:update');

//restore data
Route::get('/product_offer/restore','ProductOfferController@DeletedDataShow')->name('get:ProductOfferController:DeletedDataShow');
//storing deleted data 
Route::post('/product_offer/restore','ProductOfferController@DeletedDataStore')->name('post:ProductOfferController:DeletedDataStore');

//
//pERMANENT deleted data 
Route::post('/product_offer/forcefullydelete','ProductOfferController@DeletedDataPermanentlyDelete')->name('post:ProductOfferController:DeletedDataPermanentlyDelete');
  //delete part

  Route::post('/product_offer/show/delete','ProductOfferController@destroy')->name('post:ProductOfferController:destroy');