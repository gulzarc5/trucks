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
            Route::get('fetch/by/state/{id}', 'CityController@cityFetchByState');
        });
        Route::group(['prefix'=>'truck/type'],function(){
            Route::get('list','configurationController@truckTypeList')->name('admin.truck_type_list');
            Route::get('add/form','configurationController@truckTypeAddForm')->name('admin.truck_type_add_form');
            Route::post('add','configurationController@addTruckType')->name('admin.add_truck_type');
            Route::get('status/{id}/{status}','configurationController@truckTypeStatus')->name('admin.truck_type_status');
            Route::get('edit/form/{id}','configurationController@editTruckType')->name('admin.edit_truck_type_form');
            Route::put('update/{id}','configurationController@updateTruckType')->name('admin.truck_type_update');
        });

        Route::group(['prefix'=>'truck/capacity'],function(){
            Route::get('list','configurationController@truckCapacityList')->name('admin.truck_capacity_list');
            Route::get('add/form','configurationController@truckCapacityAddForm')->name('admin.truck_capacity_add_form');
            Route::post('add','configurationController@addTruckCapacity')->name('admin.add_truck_capacity');
            Route::get('edit/form/{id}','configurationController@editTruckCapacity')->name('admin.edit_truck_capacity_form');
            Route::put('update/{id}','configurationController@updateTruckCapacity')->name('admin.truck_capacity_update');
        });

        Route::group(['prefix'=>'customer'],function(){
            Route::get('list','CustomerController@customerList')->name('admin.customer_list');
            Route::get('corporate/list','CustomerController@corporateCustomerList')->name('admin.corporate_customer_list');
            // Route::get('list/ajax','CustomerController@customerListAjax')->name('admin.customer_list_ajax');
            Route::get('list/individual/ajax','CustomerController@IndividualCustomerListAjax')->name('admin.individual_customer_list_ajax');
            Route::get('list/corporate/ajax','CustomerController@CorporateCustomerListAjax')->name('admin.corporate_customer_list_ajax');
            Route::get('status/{id}/{status}','CustomerController@status')->name('admin.customer_status');
            Route::get('edit/form/{id}','CustomerController@editCustomerForm')->name('admin.edit_customer_form');
            Route::post('update/{id}','CustomerController@updateCustomer')->name('admin.update_customer');

            Route::get('details/{id}','CustomerController@customerDetails')->name('admin.customer_details');
        });

        Route::group(['prefix'=>'client'],function(){
            Route::get('detail/{id}','ClientController@clientDetail')->name('admin.client_detail');
            Route::group(['prefix'=>'owner'],function(){
                Route::get('list','ClientController@ownerList')->name('admin.owner_list');
                Route::get('add/form','ClientController@ownerAddForm')->name('admin.owner_add_form');
                Route::post('add','ClientController@addOwner')->name('admin.add_owner');
                Route::get('status/{id}/{status}','ClientController@status')->name('admin.owner_status');
                Route::get('edit/form/{id}','ClientController@editOwnerForm')->name('admin.edit_owner_form');
                Route::post('update/{id}','ClientController@updateOwner')->name('admin.update_owner');
                Route::get('list/ajax','ClientController@ownerListAjax')->name('admin.owner_list_ajax');
                Route::get('detail/{id}','ClientController@ownerDetail')->name('admin.owner_detail');

                Route::get('verify/{mobile}','ClientController@ownerVerify')->name('admin.owner_verify');
            });
            Route::group(['prefix'=>'driver'],function(){
                Route::get('list','ClientController@driverList')->name('admin.driver_list');
                Route::get('list/ajax','ClientController@driverListAjax')->name('admin.driver_list_ajax');
                Route::get('add/form','ClientController@driverAddForm')->name('admin.driver_add_form');
                Route::post('add','ClientController@addDriver')->name('admin.add_driver');
                Route::get('edit/form/{id}','ClientController@editDriverForm')->name('admin.edit_driver_form');
                Route::post('update/{id}','ClientController@updateDriver')->name('admin.update_driver');
                Route::get('status/{id}/{status}','ClientController@driverStatus')->name('admin.driver_status');
                Route::get('verify/{driver_mobile}/{owner_mobile}','ClientController@driverVerify')->name('admin.owner_verify');

                Route::get('detail/{id}','ClientController@clientDetail')->name('admin.driver_detail');
            });
            Route::group(['prefix'=>'truck'],function(){
                Route::get('list','TruckController@trucksList')->name('admin.trucks_list');
                Route::get('add/form','TruckController@truckAddForm')->name('admin.truck_add_form');
                Route::post('add','TruckController@addTruck')->name('admin.add_truck');
                Route::get('status/{id}/{status}','TruckController@truckStatus')->name('admin.truck_status');
                Route::get('edit/form/{id}','TruckController@editTruckForm')->name('admin.edit_truck_form');
                Route::post('update/{id}','TruckController@updateTruck')->name('admin.update_truck');
                Route::get('list/ajax','TruckController@truckListAjax')->name('admin.truck_list_ajax');
                Route::get('images/{id}','TruckController@truckImages')->name('admin.truck_images');

                Route::post('add/new/images/','TruckController@addNewImages')->name('admin.truck_add_new_images');
                Route::get('make/cover/image/{truck_id}/{image_id}','TruckController@makeCoverImage')->name('admin.truck_make_cover_image');
                Route::get('delete/image/{image_id}','TruckController@deleteImage')->name('admin.truck_delete_image');

                Route::get('detail/{id}','TruckController@truckDetail')->name('admin.truck_detail');

            });
        });

        Route::group(['prefix' => 'order'],function(){
            Route::get('new/list','OrderController@newOrders')->name('admin.new_order_list');
            Route::get('approved/list','OrderController@approvedOrders')->name('admin.approved_order_list');
            Route::get('update/status/{id}/{status}','OrderController@updateStatus')->name('admin.update_order_status');

            Route::get('bid/{order_id}','BidController@bidList')->name('admin.bid_list');
        });

        // Ajax//
    });
});
