<?php
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
            Route::get('index', 'DashboardController@index')->name('admin.index');
//            Users Routes
            Route::resource('users', 'UserController')->except(['show']);
//            Categories Routes
            Route::resource('categories', 'CategoryController')->except(['show']);

//            products Routes
            Route::resource('products', 'ProductController')->except(['show']);

//            clients Routes
            Route::resource('clients', 'ClientController')->except(['show']);


//            clients Orders Routes
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);


            // Order Routes
            Route::resource('orders', 'OrderController')->except(['show']);

//            To Show Orders Products
            Route::get('/orders/{order}/products' , 'OrderController@products')->name('orders.products');


        });
    });
