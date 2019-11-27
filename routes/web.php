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

Route::get('/dashboard', 'SessionController@index')->middleware('auth');
Route::get('/sessions/create', 'SessionController@create')->middleware('auth');

Route::post('/sessions', 'SessionController@store')->middleware('auth');
Route::get('/sessions/{examSession}', 'SessionController@show')->middleware('auth');
Route::put('/sessions/{examSession}/complete', 'SessionController@isComplete')->middleware('auth');
Route::put('/sessions/{examSession}/send', 'SessionController@sendMail')->middleware('auth');

Route::get('/teachers', 'TeacherController@index')->middleware('auth');
Route::post('/teachers', 'TeacherController@store')->middleware('auth');
Route::post('/attach', 'TeacherController@attach')->middleware('auth');
Route::post('/detach', 'TeacherController@detach')->middleware('auth');
Route::post('/csvfile', 'TeacherController@storecsv')->middleware('auth');

Route::delete('/teachers/{teacher}', 'TeacherController@destroy')->middleware('auth');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Teachers
*/
Route::post('/modals' ,'ModalController@store');
