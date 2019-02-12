<?php
  
  //enter page to offer for category
  
  Route::get('/category_offer','CategoryOfferController@create')->name('get:CategoryOfferController:create');
  
  //storing offer details
  
  Route::post('/category_offer','CategoryOfferController@store')->name('post:CategoryOfferController:store');
  
  //all existing offer shown
  
  Route::get('/category_offer/show','CategoryOfferController@show')->name('get:CategoryOfferController:show');
  
  //edit part
  
  Route::get('/category_offer/edit','CategoryOfferController@edit')->name('get:CategoryOfferController:edit');
  
  //update details
  
  Route::post('/category_offer/edit','CategoryOfferController@update')->name('post:CategoryOfferController:update');
  
//restore data
Route::get('/category_offer/restore','CategoryOfferController@DeletedDataShow')->name('get:CategoryOfferController:DeletedDataShow');
//storing deleted data 
Route::post('/category_offer/restore','CategoryOfferController@DeletedDataStore')->name('post:CategoryOfferController:DeletedDataStore');

//
//pERMANENT deleted data 
Route::post('/category_offer/forcefullydelete','CategoryOfferController@DeletedDataPermanentlyDelete')->name('post:CategoryOfferController:DeletedDataPermanentlyDelete');

  //delete part

  Route::post('/category_offer/show/delete','CategoryOfferController@destroy')->name('post:CategoryOfferController:destroy');