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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('dashboardapi', 'DashboardController@index');
    Route::resource('userapi', 'UserController', ['except' => ['create']]);
    Route::patch('updateuserapi/{any}', 'UserController@renew');
    Route::patch('changepasswordapi/{any}', 'UserController@renewpassword');
    Route::resource('roleapi', 'RoleController', ['except' => ['create']]);
    Route::resource('userroleapi', 'UserRoleController', ['except' => ['create']]);
    Route::get('chartapi', 'DashboardController@chart');
    Route::get('chart2api/{any}', 'DashboardController@chart2');
    Route::resource('categoryapi', 'CategoryController', ['except' => ['create']]);
    Route::get('checkcategoryapi', 'CategoryController@checkCategory');
    Route::resource('roomapi', 'RoomController', ['except' => ['create']]);
    Route::get('checkroomapi', 'RoomController@checkRoom');
    Route::resource('rackapi', 'RackController', ['except' => ['create']]);
    Route::get('checkrackapi', 'RackController@checkRack');
    Route::get('rackwithslotapi', 'RackController@rackWithSlot');
    Route::resource('archiveapi', 'ArchiveController', ['except' => ['create']]);
    Route::get('rackinroomapi/{any}', 'ArchiveController@rackinroom');
    Route::patch('confirmarchiveapi/{any}', 'ArchiveController@confirm');
    Route::patch('undoconfirmarchiveapi/{any}', 'ArchiveController@undoconfirm');
});

Route::group(['prefix'=>'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});