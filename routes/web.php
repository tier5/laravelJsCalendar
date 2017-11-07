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

Route::get('get-calendars', 'CalendarController@get')->name("getCal");
Route::get('calendars', 'CalendarController@index')->name("index");
Route::post('/calendarstore', 'CalendarController@store')->name("store");
Route::post('/calendarupdate', 'CalendarController@update')->name("edit");
Route::post('/calendardrop', 'CalendarController@drop')->name("drop");
Route::post('/calendardelete', 'CalendarController@destroy')->name("delete");

