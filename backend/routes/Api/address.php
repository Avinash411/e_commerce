<?php


//get all country here required only user id as user

Route::post('/getcountry','AddressController@getCountry')->name('post:AddressController:getCountry');

//find all state of particular country by paasing country id as country 

Route::post('/getstate','AddressController@getState')->name('post:AddressController:getState');

//find all city of particular state by paasing state id as state 

Route::post('/getcity','AddressController@getCity')->name('post:AddressController:getCity');

//Address part

//adding address data so here required data name ,moblie no,pin code,Locality,Address (area and street like textarea) ,city,state,address type like home or work

Route::post('/AddingAddress','AddressController@store')->name('post:AddressController:store');

//show all store address of particular user here required user id as user

Route::post('/getAllAddress','AddressController@show')->name('post:AddressController:show');


//edit address here requierd user id and address Id

Route::post('/editAddress','AddressController@edit')->name('post:AddressController:edit');

//soft delete address here requierd user id and address Id

Route::post('/deleteAddress','AddressController@destroy')->name('post:AddressController:destroy');