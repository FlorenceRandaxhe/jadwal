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
//Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/dashboard', 'SessionController@index')->middleware('auth'); // dashboard view
Route::get('/sessions/create', 'SessionController@create')->middleware('auth'); // show view to create a new exam session

Route::post('/sessions', 'SessionController@store')->middleware('auth'); // store the new exam session
Route::get('/sessions/{examSession}', 'SessionController@show')->middleware('auth'); // show one exam session
Route::put('/sessions/{examSession}', 'SessionController@update')->middleware('auth'); // store the update exam session
Route::get('/sessions/{examSession}/edit', 'SessionController@edit')->middleware('auth');
Route::put('/sessions/{examSession}/complete', 'SessionController@isComplete')->middleware('auth'); // close the session
Route::put('/sessions/{examSession}/send', 'SessionController@sendMail')->middleware('auth'); // send mails to teachers
Route::put('/sessions/{examSession}/reminder', 'SessionController@sendRemiderMail')->middleware('auth'); // send mails to teachers
Route::get('/sessions/{examSession}/preview', 'SessionController@previewMail')->middleware('auth');

Route::get('/teachers', 'TeacherController@index')->middleware('auth'); // teachers view
Route::post('/teachers', 'TeacherController@store')->middleware('auth'); // store a new teacher
Route::post('/teachers/csvfile', 'TeacherController@storecsv')->middleware('auth'); // add teacher with a csv file
Route::post('/teachers/attach', 'TeacherController@attach')->middleware('auth'); // create a new relation between teacher and exam session
Route::post('/teachers/{teacher}/detach', 'TeacherController@detach')->middleware('auth'); // delete relation between teacher and exam session
Route::get('/teachers/{teacher}', 'TeacherController@show')->middleware('auth'); // show one's teacher modals
Route::delete('/teachers/{teacher}', 'TeacherController@destroy')->middleware('auth'); // delete a teacher
Route::get('/teachers/{teacher}/pdf', 'ModalController@downloadPDF')->middleware('auth');

/**
 * Teachers
*/
Route::post('/modals' ,'ModalController@store'); // store a new modal
Route::post('/modals/{session}/duplicate', 'ModalController@duplicate'); // duplicate a former modal
Route::put('/modals/{token}/complete', 'ModalController@completeModals'); // mark the session as complete
Route::delete('/modals/{modal}', 'ModalController@destroy'); // delete a modal
Route::get('/modals/{token}' ,'ModalController@index');
Route::get('/teachers/{teacher}/teacherPdf', 'ModalController@teacherDownloadPDF');


/*
 *  envoi des mails ok
 *  mails de rappel ok
 *  version pdf des modalités ok
 *  design pour les profs ok
 *  repartir d'une ancienne session pour les profs ok
 *  repartir d'une ancienne session OK
 *  csv file
 *  preview mail
 */