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

Route::get('/', 'DefaultController@index')->name('home');
Route::post('/', 'DefaultController@processData');

Route::get('director/addteacher', 'DirectorController@addTeacherForm');
Route::post('director/addteacher', 'DirectorController@addTeacher');

Route::get('director/addsubject', 'DirectorController@addSubjectForm');
Route::post('director/addsubject', 'DirectorController@addSubject');

Route::get('director/addclass', 'DirectorController@addClassForm');
Route::post('director/addclass', 'DirectorController@addClass');

Route::get('/logout', 'DefaultController@logout');