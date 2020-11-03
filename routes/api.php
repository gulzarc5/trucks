<?php

use Illuminate\Http\Request;

Route::group(['namespace'=>'Api'],function(){
    Route::get('/signup/otp/send/{mobile}', 'CustomerController@signUpOtp');
    Route::get('signUp/otp/verify/{mobile}/{otp}', 'CustomerController@signUpOtpVerify');
    Route::post('customer/registration', 'CustomerController@customerRegistration');
    Route::post('customer/login', 'CustomerController@customerLogin');

    Route::get('/customer/forgot/otp/send/{mobile}', 'CustomerController@forgotOtp');
    Route::post('customer/forgot/password/change/', 'CustomerController@forgotPasswordChange');

    Route::get('/truck/type/capacity/list', 'TruckController@truckTypeList');


    Route::group(['middleware'=>'auth:customerApi','prefix'=>'customer'],function(){
        Route::get('profile/{id}', 'CustomerController@profileFetch');
        Route::put('profile/update/{id}', 'CustomerController@profileUpdate');
        Route::put('change/password/{id}', 'CustomerController@changePassword');
    });


    Route::post('client/registration','ClientController@registration');
    Route::post('client/login','ClientController@login');
    Route::get('state/list', 'ConfigurationController@stateList');
    Route::get('city/list/{state_id}', 'ConfigurationController@cityList');

    Route::group(['middleware' => 'auth:userApi'], function () {
        Route::get('client/profile/{id}','ClientController@clientProfile');
        Route::put('client/profile/update/{id}','ClientController@clientProfileUpdate');
        Route::get('client/verify/{mobile}/{type}','ClientController@clientVerify');

        Route::post('owner/add/driver','ClientController@addDriver');
        Route::get('owner/driver/list/{owner_id}','ClientController@ownerDriverList');
        Route::get('owner/driver/status/{driver_id}/{status}','ClientController@driverStatusUpdate');

        Route::group(['prefix' => 'truck'], function () {
            Route::post('add','TruckController@addTruck');
            Route::get('list/owner/{owner_id}','TruckController@truckList');
            Route::get('fetch/by/id/{truck_id}','TruckController@truckFetchById');
        });
    });
});


