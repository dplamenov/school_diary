<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Models\Subject;
use App\Http\Controllers\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function addTeacherForm(Request $request)
    {
        $subject = array();
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $subject = new Subject();
        $subject = $subject->getAllSubject();

        foreach ($subject as $item) {
            $subjects[] = $item->subject_name;
        }

        return view('addteacherform', ['subjects' => $subjects]);
    }

    public function addTeacher(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $validate = $this->validate($request, [
            'fullname' => 'min:8',
            'subjects' => 'array'
        ]);

        DB::insert("INSERT INTO `teachers` (`teacher_id`, `teacher_name`) VALUES (NULL, ?)", [$validate['fullname']]);
        $last_id = DB::select('SELECT * FROM `teachers` WHERE `teacher_name` = ?', [$validate['fullname']])[0]->teacher_id;
        DB::insert("INSERT INTO `users` (`user_id`, `username`, `password`, `type`, `email`, `id`) VALUES (NULL, ?, ?, 0, '', $last_id)", [strtolower(str_replace(' ', '', $validate['fullname'])), strtolower(str_replace(' ', '', $validate['fullname']))]);

        foreach ($validate['subjects'] as $subject) {
            DB::insert("INSERT INTO `teacher_subject` (`teacher_id`, `subject_id`) VALUES (?, ?)", [$last_id, $subject + 1]);
        }

        return redirect(url('/'));

    }

    public function addSubjectForm(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        return view('addsubjectform');
    }

    public function addSubject(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $validate = $this->validate($request, [
            'subject' => 'unique:subjects,subject_name|required'
        ], [
            'subject.unique' => 'Subject already created'
        ]);

        DB::insert('INSERT INTO `subjects` (`subject_name`) VALUES (?)', [$validate['subject']]);

        return redirect(url('/'));
    }

    public function addClassForm(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $teacher_model = new Teacher();

        foreach ($teacher_model->getAllTeacher() as $teacher) {
            $teachers[$teacher->teacher_id] = $teacher->teacher_name;
        }

        $subject_model = new Subject();
        $all_subject = $subject_model->getAllSubject();
        return view('addclassform', ['teachers' => $teachers, 'subjects' => $all_subject]);
    }

    public function addClass(Request $request)
    {
        $validate = $this->validate($request, [
            'class_name' => 'required',
            'teacher' => 'required',
            'subject' => 'array'
        ]);
        $teacher_model = new Teacher();
        foreach ($validate['subject'] as $subject){
            echo '<pre>' . print_r($teacher_model->getAllTeacherBySubjectId($subject), true) . '</pre>';
        }
        //DB::insert('INSERT INTO `classes` (`class_name`, `teacher`, `count`) VALUES (?, ?, 0)', [$validate['class_name'], $validate['teacher']]);
        //return redirect()->route('home');
    }
}