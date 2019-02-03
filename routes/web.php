<?php

use \Illuminate\Support\Facades\Route;

Route::get('/', 'DefaultController@index')->name('home');
Route::post('/', 'DefaultController@processData');
Route::get('director/addteacher', 'DirectorController@addTeacherForm');
Route::post('director/addteacher', 'DirectorController@addTeacher');
Route::get('director/addsubject', 'DirectorController@addSubjectForm');
Route::post('director/addsubject', 'DirectorController@addSubject');
Route::get('director/addclass', 'DirectorController@addClassForm');
Route::post('director/addclass', 'DirectorController@addClass');
Route::get('/logout', 'DefaultController@logout');
Route::post('director/select/teacher', 'DirectorController@selectTeacher');
Route::get('class/{id}', 'TeacherController@listOfClass');
Route::get('teacher/delete/{id}', 'DirectorController@deleteTeacher');
Route::get('subject/delete/{id}', 'DirectorController@deleteSubject');
Route::get('parent/register/{id}', 'ParentController@registerParent');