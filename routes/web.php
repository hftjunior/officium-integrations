<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Broadcast::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('/notifications', [
    'as'    => 'notifications', 'uses'  => 'Admin\NotificationController@notifications'
]);
Route::put('/notification-read', [
    'as'    => 'notification-read', 'uses'  => 'Admin\NotificationController@markAsRead'
]);
Route::put('/notification-all-read', [
    'as'    => 'notification-all-read', 'uses'  => 'Admin\NotificationController@markAllAsRead'
]);

Auth::routes();
Route::get('/home', [
    'as'    => 'home', 'uses'  => 'HomeController@index'
]);

Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'admin',
    'middleware'    => 'auth'
], function(){
    /** Security */
    /* Users */
    Route::resource('users','UserController')->middleware('permissions:users_view');
    Route::get('users_datagrid', 'UserController@getGridData')->name('users.datagrid')->middleware('permissions:users_view');
    Route::any('users_trash', 'UserController@trash')->name('users.trash')->middleware('permissions:users_restore');
    Route::any('users_restore/{id}', 'UserController@restore')->name('users.restore')->middleware('permissions:users_restore');
    Route::any('users_force_delete/{id}', 'UserController@forceDelete')->name('users.force.delete')->middleware('permissions:users_delete');
    Route::get('users_datagrid_trash', 'UserController@getGridDataTrash')->name('users.datagrid.trash')->middleware('permissions:users_restore');
    /* Permissions */
    Route::resource('permissions','PermissionController')->middleware('permissions:permissions_view');
    Route::get('permissions_datagrid', 'PermissionController@getGridData')->name('permissions.datagrid')->middleware('permissions:permissions_view');
    Route::any('permissions_trash', 'PermissionController@trash')->name('permissions.trash')->middleware('permissions:permissions_restore');
    Route::any('permissions_restore/{id}', 'PermissionController@restore')->name('permissions.restore')->middleware('permissions:permissions_restore');
    Route::any('permissions_force_delete/{id}', 'PermissionController@forceDelete')->name('permissions.force.delete')->middleware('permissions:permissions_delete');
    Route::get('permissions_datagrid_trash', 'PermissionController@getGridDataTrash')->name('permissions.datagrid.trash')->middleware('permissions:permissions_restore');
    /* Groups */
    Route::resource('groups','GroupController')->middleware('permissions:groups_view');
    Route::get('groups_datagrid', 'GroupController@getGridData')->name('groups.datagrid')->middleware('permissions:groups_view');
    Route::any('groups_trash', 'GroupController@trash')->name('groups.trash')->middleware('permissions:groups_restore');
    Route::any('groups_restore/{id}', 'GroupController@restore')->name('groups.restore')->middleware('permissions:groups_restore');
    Route::any('groups_force_delete/{id}', 'GroupController@forceDelete')->name('groups.force.delete')->middleware('permissions:groups_delete');
    Route::get('groups_datagrid_trash', 'GroupController@getGridDataTrash')->name('groups.datagrid.trash')->middleware('permissions:groups_restore');
});

Route::group([
    'prefix'        => 'person',
    'namespace'     => 'person',
    'middleware'    => 'auth'
], function(){
    /* Categories */
    Route::resource('person_categories','PersonCategoryController')->middleware('permissions:person_categories_view');
    Route::get('person_categories_datagrid', 'PersonCategoryController@getGridData')->name('person.categories.datagrid')->middleware('permissions:person_categories_view');    
    /* People */
    Route::resource('people','PersonController')->middleware('permissions:people_view');
    Route::get('people_datagrid', 'PersonController@getGridData')->name('people.datagrid')->middleware('permissions:people_view');    
});
