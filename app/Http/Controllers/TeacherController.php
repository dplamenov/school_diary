<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Classes;
use App\Http\Controllers\Models\directorGrade;
use App\Http\Controllers\Models\Grade;
use App\Http\Controllers\Models\Note;
use App\Http\Controllers\Models\Students;
use App\Http\Controllers\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function listOfClass(Request $request, $class_id)
    {
        $teacher_id = $request->session()->get('user_data')['tid'];
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $class_model = new Classes();
        if (!$class_model->classExistsById($class_id)) {
            return redirect()->route('home');
        }

        $subjects = [];

        $result = DB::select('SELECT * FROM `teacher_classes` WHERE `teacher_id` = ? and class_id = ?', [$teacher_id, $class_id]);
        for ($i = 0; $i <= count($result) - 1; $i++) {
            $subject = DB::select('SELECT * FROM `subjects` WHERE subject_id = ?', [$result[$i]->subject_id]);
            $subjects[] = $subject[0]->subject_name;
        }
        $students = [];
        $students_query = DB::select("SELECT * FROM `students_classes` LEFT JOIN `students` ON students_classes.student_id = students.student_id WHERE students_classes.class_id = ?", [$class_id]);

        foreach ($students_query as $student) {
            $students[] = $student;
        }

        try {
            $class_name = $class_model->getClassNameById($class_id);
        } catch (\Exception $exception) {
            return view('error', ['type_error' => $exception->getMessage()]);
        }

        return view('teacher_class', ['title' => 'Class ID :' . $class_id, 'subjects' => $subjects, 'students' => $students, 'class_name' => $class_name]);

    }

    public function addNote(Request $request, $student_id)
    {

        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $teacher_id = $request->session()->get('user_data')['tid'];
        $teacher_model = new Teacher();
        $student_model = new Students();
        try {
            if ($teacher_model->checkTeacherHasPermission($teacher_id, $student_id)) {
                return view('addnote', ['student' => $student_model->getStudentById($student_id)]);
            }
        } catch (\Exception $exception) {
            return view('error', ['type_error' => $exception->getMessage()]);
        }

    }

    public function storeNote(Request $request)
    {
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $teacher_id = $request->session()->get('user_data')['tid'];

        $validate = $this->validate($request, [
            'student_id' => 'required',
            'content' => 'min: 5|max:65'
        ]);

        $note = new Note();
        $note->student_id = $validate['student_id'];
        $note->teacher_id = $teacher_id;
        $note->note = $validate['content'];
        $note->signed = 0;
        $note->save();

        return redirect()->route('home');
    }

    public function addGrade(Request $request, $id)
    {
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $student = Students::find($id);

        $teacher_id = $request->session()->get('user_data')['tid'];
        $grades = directorGrade::all();

        $class = DB::select('SELECT * FROM `students_classes` WHERE student_id = ?', [$student->student_id]);
        $subjects = DB::select('SELECT * FROM `teacher_classes` WHERE class_id = ? AND teacher_id = ?', [$class[0]->class_id, $teacher_id]);

        foreach ($subjects as $key => $subject) {
            $subjects[$key]->subject = DB::select('SELECT * FROM `subjects` WHERE subject_id = ?', [$subjects[$key]->subject_id])[0]->subject_name;
        }


        return view('addgrade', ['grades' => $grades, 'student' => $student, 'subjects' => $subjects]);

    }

    public function storeGrade(Request $request)
    {
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }

        $validate = $this->validate($request, [
            '*' => 'required'
        ]);

        $grade = new Grade();
        $grade->student_id = $validate['student_id'];
        $grade->subject_id = $validate['subject'];
        $grade->grade = $validate['grade'];
        $grade->teacher_id = $teacher_id = $request->session()->get('user_data')['tid'];
        $grade->signed = 0;
        $grade->save();

        return redirect()->route('home');

    }

}