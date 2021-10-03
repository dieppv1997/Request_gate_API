<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::group(['as' => 'api.v1.'], function () {
        Route::group(['middleware' => 'auth:api'], function () {
            Route::group(['prefix' => 'users'], function () {
                Route::group(['middleware' => 'checkRole:' . config('role.admin')], function () {
                    Route::post('store', 'UserController@store');
                    Route::put('update/{id}', 'UserController@update');
                    Route::delete('destroy/{id}', 'UserController@destroy');
                });
                Route::get('/', 'UserController@index');
                Route::get('/assign/category', 'UserController@data');
                Route::get('/category/{id}', 'UserController@getUserByCategoryId');
                Route::get('/department', 'UserController@getListDepartment');
                Route::get('/me', 'UserController@getMe');
                Route::get('all', 'UserController@getAll');
                Route::get('getAdmin','UserController@getAdmin');
            });
            Route::group(['prefix' => 'request/{id}/comments'], function () {
                Route::get('/', 'CommentController@index');
                Route::post('store', 'CommentController@store');
            });
            Route::group(['prefix' => 'comment_histories'], function () {
                Route::get('/', 'CommentHistoryController@index');
            });
            Route::group(['prefix' => 'category'], function () {
                Route::get('/', 'CategoryController@index');
                Route::get('/assignee', 'CategoryController@getListAssignee');
                Route::get('/list', 'CategoryController@getListToSelectOption');
                Route::get('categoryEnable', 'CategoryController@getCategoryEnable');
                Route::group(['middleware' => 'checkRole:' . config('role.admin')], function () {
                    Route::post('store', 'CategoryController@store');
                    Route::put('update/{id}', 'CategoryController@update');
                    Route::delete('destroy/{id}', 'CategoryController@destroy');
                });
                Route::get('show/{id}', 'CategoryController@show');
            });
            Route::group(['prefix' => 'department'], function () {
                Route::get('/', 'DepartmentController@index');
                Route::group(['middleware' => 'checkRole:' . config('role.admin')], function () {
                    Route::post('store', 'DepartmentController@store');
                    Route::put('update/{id}', 'DepartmentController@update');
                });
            });
            Route::group(['prefix' => 'request'], function () {
                Route::get('/', 'RequestController@index');
                Route::get('/search', 'RequestController@getListToSearch');
                Route::get('/show/{id}', 'RequestController@show');
                Route::post('/create', 'RequestController@store');
                Route::put('/edit/{id}', 'RequestController@update');
                Route::delete('/delete/{id}', 'RequestController@destroy');
                Route::get('/assign/{id}/category', 'RequestController@getListCategoryForAssign');
            });
            Route::post('logout', 'AuthController@logout');
            Route::get('history', 'HistoryController@index');
            Route::post('changePassword', 'AuthController@changePassword');
        });
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'AuthController@login');
            Route::post('forgot', 'AuthController@forgot');
            Route::post('reset', 'AuthController@reset');
            Route::post('loginGoogle', 'Auth\\LoginController@loginGoogle');
            Route::post('signUpByGSuit', 'Auth\\LoginController@signUpByGoogleUser');
        });
        Route::get('/getDepartment', 'UserController@getListDepartment');
    });
});
