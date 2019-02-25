<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Classes;
use App\Http\Controllers\Models\directorGrade;
use App\Http\Controllers\Models\Subject;
use App\Http\Controllers\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function addTeacherForm(Request $request)
    {
        $subjects = array();
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $subject = new Subject();
        $subject = $subject->getAllSubject();

        $subjects = array();
        foreach ($subject as $key => $item) {
            $subjects[$item->subject_id] = $item->subject_name;
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
            'subjects' => 'array',
            'email' => 'email'
        ]);
        $teacher_model = new Teacher();
        if ($teacher_model->teacherExists($validate['fullname'])) {
            return view('error', ['type_error' => 'Teacher already exists.']);
        }
        DB::insert("INSERT INTO `teachers` (`teacher_id`, `teacher_name`) VALUES (NULL, ?)", [$validate['fullname']]);
        $last_id = DB::select('SELECT * FROM `teachers` WHERE `teacher_name` = ?', [$validate['fullname']])[0]->teacher_id;
        DB::insert("INSERT INTO `users` (`user_id`, `username`, `password`, `type`, `id`, `email`) VALUES 
                                                                                    (NULL, ?, ?, 0,$last_id, ?)", [strtolower(str_replace(' ', '', $validate['fullname'])), password_hash(strtolower(str_replace(' ', '', $validate['fullname'])), PASSWORD_BCRYPT), $validate['email']]);

        foreach ($validate['subjects'] as $subject) {
            DB::insert("INSERT INTO `teacher_subject` (`teacher_id`, `subject_id`) VALUES (?, ?)", [$last_id, $subject]);
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
        $teachers = array();
        foreach ($teacher_model->getAllTeacher() as $teacher) {
            $teachers[$teacher->teacher_id] = $teacher->teacher_name;
        }

        $subject_model = new Subject();
        $all_subject = $subject_model->getAllSubject();
        return view('addclassform', ['teachers' => $teachers, 'subjects' => $all_subject]);
    }

    public function addClass(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $validate = $this->validate($request, [
            'class_name' => 'required',
            'teacher' => 'required',
            'subject' => 'required|array',
            '*' => 'required'
        ]);

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

        $teacher_model = new Teacher();
        $class_model = new Classes();

        if ($class_model->classExists($validate['class_name'])) {
            return view('error', ['type_error' => 'Class already exists']);
        }
        DB::insert('INSERT INTO `classes` (`class_name`, `teacher`, `count`) VALUES (?, ?, ?)', [$validate['class_name'], $validate['teacher'], count($students)]);
        $class_id = DB::select('SELECT * FROM `classes` WHERE `class_name` = ?', [$validate['class_name']])[0]->class_id;
        foreach ($validate['subject'] as $subject) {
            $subject_name = DB::select('SELECT * FROM `subjects` WHERE `subject_id` = ?', [$subject]);
            $subjects[] = $teacher_model->getAllTeacherBySubjectId($subject);
        }
        foreach ($students as $student) {
            DB::insert("INSERT INTO `students` (`student_name`) VALUES (?)", [$student]);
            $last_id = DB::select('SELECT * FROM `students` WHERE `student_name` = ?', [$student])[0]->student_id;
            DB::insert("INSERT INTO `students_classes` (`class_id`, `student_id`) VALUES (?, ?)", [$class_id, $last_id]);
            DB::insert("INSERT INTO `users` (`user_id`, `username`, `password`, `type`, `email`, `id`) VALUES (NULL, ?, ?, 2, '', $last_id)",
                [strtolower(str_replace(' ', '', $student)), password_hash(strtolower(str_replace(' ', '', $student)), PASSWORD_BCRYPT)]);
        }
        return view('selectteacher', ['teachers' => $subjects, 'subject' => $subject_name[0]->subject_name, 'class_id' => $class_id]);


    }


    public function selectTeacher(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
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

    public function deleteTeacher(Request $request, int $teacher_id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        DB::delete('DELETE FROM `teachers` WHERE teacher_id = ?', [$teacher_id]);
        return redirect()->route('home');
    }

    public function deleteSubject(Request $request, $id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        DB::delete('DELETE FROM `subjects` WHERE `subject_id` = ?', [$id]);

        return redirect()->route('home');
    }

    public function classInfo(Request $request, int $class_id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $class_model = new Classes();
        $all_students = $class_model->getStudentsInClass($class_id);


        try {
            $class_name = $class_model->getClassNameById($class_id);
        } catch (\Exception $exception) {
            return view('error', ['type_error' => $exception->getMessage()]);
        }

        return view('classinfo', ['class_name' => $class_name, 'students' => $all_students]);
    }

    public function grade(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $grades = directorGrade::all();
        return view('addgrade_director', ['grades' => $grades]);
    }

    public function storeGrade(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $validate = $this->validate($request, [
            '*' => 'required',
            'grade_number' => 'numeric'
        ], [
            'grade_number.numeric' => 'The grade number must be a number.',
            'grade_name.required' => 'The grade name is required.'
        ]);
        $grade = new directorGrade();
        if (!$grade->isGradeExistsByName($validate['grade_name'])) {
            $grade->grade_name = $validate['grade_name'];
            $grade->grade_number = $validate['grade_number'];
            $grade->save();
            return redirect()->action('DirectorController@grade');
        } else {
            return view('error', ['type_error' => 'Grade exists']);
        }

    }

    public function deleteGrade(Request $request, $id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $director = new directorGrade();
        if ($director->isGradeExistsById($id)) {
            directorGrade::find($id)->delete();

        }
        return redirect()->action('DirectorController@grade');
    }
}