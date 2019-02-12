<?php
//get all existing category
Route::get('/allcategory','SearchProduct@getallcategory')->name('get:SearchProduct:getallcategory'); 
//product search by name

Route::get('/search_product_name','SearchProduct@create')->name('get:SearchProduct:create');

//after enter name of product then submit to search for product details

Route::post('/search_product_name','SearchProduct@search_product')->name('post:SearchProduct:search_product');

//searching for path

//Route::post('/search_path','SearchProduct@path');

//search a particular catergory all product

Route::post('/filter','SearchProduct@filter')->name('post:SearchProduct:filter');

Route::get('/path_data/{id}','SearchProduct@path_data')->name('get:SearchProduct:path_data');

Route::get('/price_asc/{id}','SearchProduct@getAscendingPrice')->name('get:SearchProduct:getAscendingPrice');

Route::get('/price_des/{id}','SearchProduct@getDescendingPrice')->name('get:SearchProduct:getDescendingPrice');

Route::get('/newest/{id}','SearchProduct@getNewest_product')->name('get:SearchProduct:getNewest_product');

Route::get('/product/{id}','SearchProduct@get_product_details')->name('get:SearchProduct:get_product_details');

//particular brand product search

Route::get('/particular_brand','SearchProduct@brand_show')->name('get:SearchProduct:brand_show');


//card data storing part

    //its form like data here requiered user->(exiets)user_id,type->product Variant id and quantity,
    //here  requiered data user (userid),type->product variant id,quantity


Route::post('/cart','SearchProduct@cartDataStore')->name('post:SearchProduct:cartDataStore');


//show all cart data of particuler user ,here required user id as user 

Route::post('/CartDataOfUser','SearchProduct@showAllCartDataByuserId')->name('post:SearchProduct:showAllCartDataByuserId');

//edit card data  here requierd data is variant id and user id and updated quantity

Route::post('/CartDataEdit','SearchProduct@EditCartDataByuserId')->name('post:SearchProduct:EditCartDataByuserId');

//remove of a particular data of particular user here requierd data is variant id and user id 

Route::post('/CartRemove','SearchProduct@DeleteCartDataByuserId')->name('post:SearchProduct:DeleteCartDataByuserId');


//Route::get('/details','DetailsController@index'); 

//here authorizied part pending


//create wishlist here requiered data user id as user and product variant id as type 

Route::post('/createwishlist','SearchProduct@createWishlist')->name('post:SearchProduct:createWishlist');

//working on this 

//showing all wish list of particular user ,here required user id as user 

Route::post('/WishlistDataOfUser','SearchProduct@showAllWishList')->name('post:SearchProduct:showAllWishList');

//now after showing wish list we have to add into card to particualr user so here requiered data user id as user and variant id as type

Route::post('/WishlistAddToCart','SearchProduct@wishlistAddToCartDataByuserId')->name('post:SearchProduct:wishlistAddToCartDataByuserId');

//remove of a particular data of particular user here requierd data is variant id as type and user id as user

Route::post('/WishlistRemove','SearchProduct@DeleteWishlistDataByuserId')->name('post:SearchProduct:DeleteWishlistDataByuserId');

