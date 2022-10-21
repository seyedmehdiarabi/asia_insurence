<?php
Route::middleware(['auth','user'])->group(function (){
    Route::get('statistics/month/visit','StatisticsController@month_visit')->name('statistics.month');
    Route::get('statistics/week/visit/{year?}','StatisticsController@week_visit')->name('statistics.week');
});

