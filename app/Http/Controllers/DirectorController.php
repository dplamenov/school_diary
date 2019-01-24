<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Models\Classes;
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
        $teacher_model = new Teacher();
        if ($teacher_model->teacherExists($validate['fullname'])) {
            return view('error', ['type_error' => 'Teacher already exists']);
        }
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
            'subject' => 'required|array',
            '*' => 'required'
        ]);
        echo '<pre>' . print_r($request->post(), true) . '</pre>';

        foreach ($request->post() as $key => $data) {
            if (strpos($key, 'name') !== false) {
                $students[$key] = $data;
            }
        }
        unset($students['class_name']);
        foreach ($students as $key => $value) {
            $s[] = $value;
        }
        $students = $s;
        foreach ($students as $student) {
            DB::insert("INSERT INTO `students` (`student_name`) VALUES (?)", [$student]);
        }
        $teacher_model = new Teacher();
        $class_model = new Classes();
        if ($class_model->classExists($validate['class_name'])) {
            return view('error', ['type_error' => 'Class already exists']);
        }
        DB::insert('INSERT INTO `classes` (`class_name`, `teacher`, `count`) VALUES (?, ?, 0)', [$validate['class_name'], $validate['teacher']]);
        $class_id = DB::select('SELECT * FROM `classes` WHERE `class_name` = ?', [$validate['class_name']])[0]->class_id;
        echo '<pre>' . print_r($class_id, true) . '</pre>';
        foreach ($validate['subject'] as $subject) {
            $subject_name = DB::select('SELECT * FROM `subjects` WHERE `subject_id` = ?', [$subject]);
            $subjects[] = $teacher_model->getAllTeacherBySubjectId($subject);
        }
        return view('selectteacher', ['teachers' => $subjects, 'subject' => $subject_name[0]->subject_name, 'class_id' => $class_id]);


    }

    private function add_class($subjects)
    {
        foreach ($subjects as $subject) {
            yield $subject;
        }
    }

    public function selectTeacher(Request $request)
    {
        $teachers = [];
        $class_id = intval(trim($request->post()['class']));
        foreach ($request->post() as $key => $data) {
            if (strpos($key, 'teacher') !== false) {
                $teachers[intval($key)] = $data;
            }
        }
        foreach ($teachers as $key => $value) {
            DB::insert("INSERT INTO `teacher_classes` (`class_id`, `teacher_id`, `subject_id`) VALUES (?, ?, ?)", [$class_id, $value, $key]);
        }

        return redirect()->route('home');
    }
}