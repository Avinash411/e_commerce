<?php

//to storing all data order part like here required like user id as user and product id as product and varaint id as variant and quantity as numberOfitem and unit price which sale price as price and address id as deliver

Route::post('/OrderPlace','OrdersController@store')->name('post:AddressController:store');

