<?php

Route::middleware(['auth','user'])->group(function (){
    Route::match(['get','post'],'setting/portal','SettingController@portal')->name('portal.setting');
    Route::match(['get','post'],'setting/workshop','SettingController@workshop')->name('workshop.setting');
    Route::match(['get','post'],'setting/salary','SettingController@salary')->name('salary.setting');
});
