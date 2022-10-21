<?php

Route::middleware(['auth', 'user'])->group(function () {

    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/panel','AdminController@author_panel')->name('author.panel');
    Route::get('/403','Admin\AdminController@error403')->name('error403');

    create_crud_route('userRole', 'UserRoleController');
    Route::get('userRole/access/{role_id}', 'UserRoleController@access');
    Route::post('userRole/access/{role_id}', 'UserRoleController@add_access');
    create_crud_route('users', 'UsersController', []);
    Route::match(['get', 'post'], 'user/sms/channel', 'UsersController@sms_setting');

    Route::get('users/{id}/additional_info', 'AdditionalInfoController@profile')->name('users.profile');

    Route::post('add/register_detail/{id}', 'ApiController@add_register_detail')->name('users.profile');
    Route::post('bankCard/update/{id}', 'ApiController@bankCardUpdate')->name('users.profile');
    Route::post('email/update/{id}', 'ApiController@updateEmail')->name('users.profile');
    Route::post('date-of-birth/update/{id}', 'ApiController@updateDateOfBirth')->name('users.profile');
    Route::post('nationalIdentityNumber/update/{id}', 'ApiController@updateNationalIdentityNumber')->name('users.profile');
    Route::post('ceremonial_title/update/{id}', 'ApiController@updateCeremonialTitle')->name('users.profile');
    Route::post('idNumber/update/{id}', 'ApiController@updateIdNumber')->name('users.profile');
    Route::post('phone/update/{id}', 'ApiController@updatePhone')->name('users.profile');
    Route::post('reagent/update/{id}', 'ApiController@updateReagent')->name('users.profile');
    Route::post('introduction/update/{id}', 'ApiController@updateIntroduction')->name('users.profile');
    Route::post('action/update/{id}', 'ApiController@updateAction')->name('users.profile');
    Route::post('description/update/{id}', 'ApiController@updateDescription')->name('users.profile');
    Route::post('address/update/{id}', 'ApiController@updateAddress')->name('users.profile');

});

Auth::routes();

Route::get('logout',function (){
    Auth::logout();
    return redirect('admin_login');
});

Route::get('/admin_login', 'auth\LoginController@admin_login_form')->middleware('guest');
Route::get('/403','UsersController@error403')->name('error403');


Route::get('/confirm', 'Auth\RegisterController@confirm')->middleware('guest');

Route::get('password/confirm', 'Auth\ForgotPasswordController@confirm')->middleware('guest');
Route::post('password/confirm', 'Auth\ForgotPasswordController@check_confirm_code')->middleware('guest');

Route::post('register/active_account', 'Auth\RegisterController@active_account')->name('active.account');

Route::post('register/ajax/resend', 'ApiController@resend')->name('sms.resend');

Route::get('/statistics/user','UsersController@statistics_user');






