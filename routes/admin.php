<?php

// 管理后台
Route::group(['prefix' => 'admin'], function (){

    // 登录展示
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');

    // 登录行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');

    // 登出
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');

    // 验证 auth:+guard的名字
    Route::group(['middleware' => 'auth:admin'], function (){
        // 首页
        Route::get('/home', '\App\Admin\Controllers\HomeController@index');

        // Gate 权限判断，使用can关键字
        Route::group(['middleware' => 'can:system'], function () {

            // 管理人员模块
            Route::get('/users', '\App\Admin\Controllers\UserController@index'); // 显示页面
            Route::get('/users/create', '\App\Admin\Controllers\UserController@create'); // 创建的页面
            Route::post('/users/store', '\App\Admin\Controllers\UserController@store'); // 创建操作
            Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role'); // 查某一用户的角色页面
            Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole'); // 修改某一用户的角色

            // 角色
            Route::get('/roles', '\App\Admin\Controllers\RoleController@index'); // 列表
            Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create'); // 创建页面
            Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store'); // 创建操作
            Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission'); // 查某一角色的权限页面
            Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission'); // 修改某一角色的权限

            // 权限
            Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index'); // 列表
            Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create'); // 创建页面
            Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store'); // 创建操作
        });

        Route::group(['middleware' => 'can:posts'], function () {

            // 审核模块
            Route::get('/posts', '\App\Admin\Controllers\PostController@index');// 显示审核模块页面
            Route::post('/posts/{post}/status', '\App\Admin\Controllers\PostController@status');// 文章操作
        });

        Route::group(['middleware' => 'can:topic'], function (){

            // 专题管理
            Route::resource('topics', '\App\Admin\Controllers\TopicController', ['only' => ['index', 'create', 'store', 'destroy']]);
        });
    });

});