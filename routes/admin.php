<?php

Route::group(['namespace' => 'Admin'],function(){
    Route::get('/admin/login','LoginController@index')->name('admin.login_form');
    Route::post('login', 'LoginController@adminLogin');


    Route::group(['middleware'=>'auth:admin','prefix'=>'admin'],function(){
        Route::get('/dashboard', 'DashboardController@dashboardView')->name('admin.deshboard');
        Route::post('logout', 'LoginController@logout')->name('admin.logout');
        Route::group(['prefix'=>'state'],function(){
            Route::get('list','StateController@stateList')->name('admin.state_list');
            Route::get('add/form','StateController@stateAddForm')->name('admin.state_add_form');
            Route::post('add','StateController@addState')->name('admin.add_state');
            Route::get('status/{id}/{status}','StateController@stateStatus')->name('admin.state_status');
            Route::get('edit/form/{id}','StateController@editState')->name('admin.edit_state_form');
            Route::put('update/{id}','StateController@updateState')->name('admin.state_update');
        });
        
        Route::group(['prefix'=>'city'],function(){
            Route::get('list','CityController@cityList')->name('admin.city_list');
            Route::get('add/form','CityController@cityAddForm')->name('admin.city_add_form');
            Route::post('add','CityController@addCity')->name('admin.add_city');
            Route::get('status/{id}/{status}','CityController@cityStatus')->name('admin.city_status');
            Route::get('edit/form/{id}','CityController@editCity')->name('admin.edit_city_form');
            Route::put('update/{id}','CityController@cityUpdate')->name('admin.city_update');
        });

        Route::group(['prefix'=>'customer'],function(){
            Route::get('list','CustomerController@customerlist')->name('admin.customer_list');
            Route::get('add/form','CustomerController@customerAddForm')->name('admin.customer_add_form');
            Route::post('add','CustomerController@addCustomer')->name('admin.add_customer');
            Route::get('status/{id}/{status}','CustomerController@status')->name('admin.customer_status');
            Route::get('edit/form/{id}','CustomerController@editCustomerForm')->name('admin.edit_customer_form');
            Route::post('update/{id}','CustomerController@updateCustomer')->name('admin.update_customer');
        });
        Route::group(['prefix'=>'client'],function(){
            Route::group(['prefix'=>'owner'],function(){
                Route::get('list','ClientController@ownerList')->name('admin.owner_list');
                Route::get('add/form','ClientController@ownerAddForm')->name('admin.owner_add_form');
                Route::post('add','ClientController@addOwner')->name('admin.add_owner');
                Route::get('status/{id}/{status}','ClientController@status')->name('admin.owner_status');
                Route::get('edit/form/{id}','ClientController@editOwnerForm')->name('admin.edit_owner_form');
                Route::post('update/{id}','ClientController@updateOwner')->name('admin.update_owner');
                Route::get('city/list/{state_id}','ClientController@fetchCity')->name('admin.fetch_city');
                Route::get('list/ajax','ClientController@ownerListAjax')->name('admin.owner_list_ajax');
            });
            Route::group(['prefix'=>'driver'],function(){
                Route::get('list','ClientController@driverList')->name('admin.driver_list');
                Route::get('add/form','ClientController@driverAddForm')->name('admin.driver_add_form');
                Route::post('add','ClientController@addDriver')->name('admin.add_driver');
                Route::get('edit/form/{id}','ClientController@editDriverForm')->name('admin.edit_driver_form');
                Route::post('update/{id}','ClientController@updateDriver')->name('admin.update_driver');
                Route::get('status/{id}/{status}','ClientController@driverStatus')->name('admin.driver_status');
                Route::get('retrive/owner/names/','ClientController@retriveOwnerNames')->name('admin.retrive_owner_names');
                Route::get('list/ajax','ClientController@driverListAjax')->name('admin.driver_list_ajax');
            });
            Route::group(['prefix'=>'truck'],function(){
                Route::get('list','TruckController@trucksList')->name('admin.trucks_list');
                Route::get('add/form','TruckController@truckAddForm')->name('admin.truck_add_form');
                Route::post('add','TruckController@addTruck')->name('admin.add_truck');
                Route::get('status/{id}/{status}','TruckController@truckStatus')->name('admin.truck_status');
                Route::get('edit/form/{id}','TruckController@editTruckForm')->name('admin.edit_truck_form');
                Route::post('update/{id}','TruckController@updateTruck')->name('admin.update_truck');
                Route::get('list/ajax','TruckController@truckListAjax')->name('admin.truck_list_ajax');

            });
        });

        // Ajax//

        

    });
});
