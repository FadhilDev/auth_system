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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['register' => false]);
Route::resource('admin','AdminController');
Route::get('edit-password/{id}','AdminController@edit_password')->name('edit-password');
Route::post('update-password/{id}','AdminController@update_password')->name('update-password');
