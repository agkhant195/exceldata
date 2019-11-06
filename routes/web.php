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

Route::group(['prefix' => 'admin/users'], function () {
    Route::get('/export', 'UsersImportExport@export')->name('users.export');
    Route::get('/upload', 'UsersImportExport@upload')->name('users.upload');
    Route::post('/import', 'UsersImportExport@import')->name('users.import');
});

Route::group(['prefix' => 'admin/notices'], function () {
    Route::get('/export', 'NoticesImportExport@export')->name('notices.export');
    Route::get('/upload', 'NoticesImportExport@upload')->name('notices.upload');
    Route::post('/import', 'NoticesImportExport@import')->name('notices.import');
});

Route::group(['prefix' => 'admin/salary'], function () {
    Route::get('/', 'SalaryCalculate@index')->name('salary.index');
    Route::post('/calculate', 'SalaryCalculate@calculate')->name('salary.calculate');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
