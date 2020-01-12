<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
// sessions
Route::resource('sessions', 'SessionController');
Route::put('/sessions/{session}/complete', 'SessionController@isComplete')->middleware('auth');
Route::get('/sessions/{session}/preview', 'SessionController@previewForm')->middleware('auth');
// teacher
Route::resource('teachers', 'TeacherController');
Route::post('/teachers/csvfile', 'TeacherController@storecsv')->middleware('auth');
Route::post('/teachers/attach', 'TeacherController@attach')->middleware('auth');
Route::post('/teachers/{teacher}/detach', 'TeacherController@detach')->middleware('auth');
// send mails
Route::put('/sessions/{examSession}/send', 'MailController@sendMail')->middleware('auth');
Route::put('/sessions/{examSession}/reminder', 'MailController@sendRemiderMail')->middleware('auth');
// download pdf
Route::get('/teachers/{teacher}/pdf', 'PdfController@downloadPDF')->middleware('auth');
Route::get('/teachers/{teacher}/{token}/teacherPdf', 'PdfController@downloadTeacherPDF');
// manage modals
Route::post('/modals' ,'ModalController@store');
Route::post('/modals/{modal}/duplicate', 'ModalController@duplicate');
Route::put('/modals/{token}/complete', 'ModalController@completeModals');
Route::delete('/modals/{modal}', 'ModalController@destroy');
Route::get('/modals/{token}' ,'ModalController@index');
