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
Route::get('parent/register/{id}', 'ParentController@registerParentForm');
Route::post('parent/register/{id}', 'ParentController@registerParent');
Route::get('director/class/{id}', 'DirectorController@classInfo');
Route::get('student/{id}', 'StudentController@studentFromTeacher');
Route::get('student/add/note/{student_id}', 'TeacherController@addNote');
Route::post('student/add/note', 'TeacherController@storeNote');
Route::get('parent/notes/sign/{id}', 'ParentController@signed');
Route::get('director/grade', 'DirectorController@grade');
Route::post('director/grade', 'DirectorController@storeGrade');
Route::get('director/grade/delete/{id}', 'DirectorController@deleteGrade' );
Route::get('student/add/grade/{student_id}', 'TeacherController@addGrade');
Route::post('student/add/grade', 'TeacherController@storeGrade');
Route::get('parent/grades/sign/{grade_id}', 'ParentController@signedGrade');
Route::get('changepassword','DefaultController@changePasswordForm');
Route::post('changepassword','DefaultController@changePassword');
Route::get('system/gettime', 'SystemController@getTime');
Route::get('director/add/student/{class_id}', 'DirectorController@addStudentForm');
Route::post('director/add/student', 'DirectorController@addStudent');
Route::get('director/delete/student/{id}', 'DirectorController@deleteStudent');
Route::get('director/edit/student/{id}', 'DirectorController@editStudentForm');
Route::post('director/edit/student', 'DirectorController@editStudent');