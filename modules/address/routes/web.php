<?php

Route::prefix('user')->middleware(['auth','user'])->group(function (){
    Route::get('getAddress/{id}','AddressController@getAddress')->name('address.get');
    Route::post('/addAddress','AddressController@create')->name('address.create');
    Route::post('/updateAddress/{user_id}','AddressController@update')->name('address.update');
    Route::delete('/removeAddress/{user_id}/{address_id}','AddressController@destroy')->name('address.destroy');
//    Route::get('profile/address','UserController@address')->name('profile.address');
});
