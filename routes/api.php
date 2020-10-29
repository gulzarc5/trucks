<?php

use Illuminate\Http\Request;

Route::group(['namespace'=>'Api'],function(){
    Route::get('/signup/otp/send/{mobile}', 'CustomerController@signUpOtp');
    Route::get('signUp/otp/verify/{mobile}/{otp}', 'CustomerController@signUpOtpVerify');
    Route::post('customer/registration', 'CustomerController@customerRegistration');
    Route::post('customer/login', 'CustomerController@customerLogin');

    Route::get('/customer/forgot/otp/send/{mobile}', 'CustomerController@forgotOtp');
    Route::post('customer/forgot/password/change/', 'CustomerController@forgotPasswordChange');

    Route::group(['middleware'=>'auth:customerApi','prefix'=>'customer'],function(){
        Route::get('profile/{id}', 'CustomerController@profileFetch');
        Route::put('profile/update/{id}', 'CustomerController@profileUpdate');
        Route::put('change/password/{id}', 'CustomerController@changePassword');
    });

    Route::post('owner/registration','OwnerController@registration');
    Route::post('owner/login','OwnerController@login');
    Route::group(['middleware' => 'auth:userApi'], function () {
        Route::get('client/profile/{id}','OwnerController@clientProfile');
        Route::put('client/profile/update/{id}','OwnerController@clientProfileUpdate');
    });
});


