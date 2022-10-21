<?php

Route::middleware(['auth','user'])->group(function (){
    create_crud_route('products','ProductController',[]);
    Route::post('search_product','ProductController@search_product');
});
