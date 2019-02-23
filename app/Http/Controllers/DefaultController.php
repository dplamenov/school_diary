<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Classes;
use App\Http\Controllers\Models\directorGrade;
use App\Http\Controllers\Models\Grade;
use App\Http\Controllers\Models\Note;
use App\Http\Controllers\Models\Parents;
use App\Http\Controllers\Models\Students;
use App\Http\Controllers\Models\Subject;
use App\Http\Controllers\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;

class DefaultController extends Controller
{
    public function index(Request $request)
    {
        $user_model = new Models\User();
        if ($request->session()->get('islogged', false)) {
            if ($request->session()->get('user_data')['type'] == 'director') {

                $subject_model = new Subject();
                $classes_model = new Classes();
                $teachers = DB::select("SELECT * FROM teachers LEFT JOIN teacher_subject ON teachers.teacher_id = teacher_subject.teacher_id LEFT JOIN subjects ON teacher_subject.subject_id = subjects.subject_id");
                $result = [];

                foreach ($teachers as $teacher) {
                    $result[$teacher->teacher_id]['name'] = $teacher->teacher_name;
                    $gen = $subject_model->getSubjectByTeacherId(intval($teacher->teacher_id));
                    $result[$teacher->teacher_id]['subjects'] = $gen;
                }
                foreach ($result as $key => $value) {
                    $result[$key]['subject'] = implode(', ', $result[$key]['subjects']);
                    unset($result[$key]['subjects']);
                }

                $classes = [];
                foreach ($classes_model->getAllClasses() as $class) {
                    $classes[] = $class;
                }
                $all_subject = $subject_model->getAllSubject();


                return view('director', ['user_data' => $request->session()->get('user_data'), 'teachers' => $result, 'subjects' => $all_subject, 'classes' => $classes]);
            } elseif (strtolower($request->session()->get('user_data')['type']) == 'teacher') {

                $r = DB::select('SELECT * FROM `users` LEFT JOIN `teachers` ON users.id = teachers.teacher_id WHERE users.user_id = ?', [$request->session()->get('user_data')['id']]);
                unset($r[0]->password);
                $name = $r[0]->teacher_name;
                $class = DB::select('SELECT * FROM `classes` WHERE `teacher` = ?', [$r[0]->teacher_id]);

                $classes = DB::select("SELECT * FROM `teacher_classes` LEFT JOIN `classes` ON teacher_classes.class_id = classes.class_id WHERE teacher_classes.teacher_id = ?", [$r[0]->teacher_id]);

                return view('teacher', ['user_data' => $request->session()->get('user_data'), 'name' => $name, 'class' => $class, 'classes' => $classes]);
            } elseif (strtolower($request->session()->get('user_data')['type']) == 'student') {

                $id = $request->session()->get('user_data')['tid'];
                $class = DB::select('SELECT * FROM `classes` LEFT JOIN `students_classes` ON `classes`.`class_id` = `students_classes`.`class_id`  WHERE `students_classes`.`student_id` = ?', [$id]);

                $notes = Note::where('student_id', '=', $id)->where('signed', 0)->get();
                foreach ($notes as $key => $note) {
                    $notes[$key]->teacher = Teacher::getTeacherById($note->teacher_id)->teacher_name;
                }
                $name = DB::select('SELECT * FROM `students` WHERE `student_id` = ?', [$request->session()->get('user_data')['tid']])[0]->student_name;
                $grades = DB::select('SELECT * FROM `grades` LEFT JOIN `students` ON grades.student_id = students.student_id LEFT JOIN `subjects` ON subjects.subject_id = grades.subject_id LEFT JOIN `teachers` ON teachers.teacher_id = grades.teacher_id LEFT JOIN grade ON grade.grade_id = grades.grade where grades.student_id = ?', [$id]);
                return view('student', ['user_data' => $request->session()->get('user_data'), 'name' => $name, 'class' => $class[0]->class_name, 'notes' => $notes, 'grades' => $grades]);
            } elseif (strtolower($request->session()->get('user_data')['type']) == 'parent') {
                $parent_id = $request->session()->get('user_data')['tid'];
                $parent = Parents::find($parent_id);
                $student = Students::find($parent->student_id);

                $unsigned_notes = Note::where('student_id', '=', $student->student_id)->where('signed', 0)->get();
                foreach ($unsigned_notes as $key => $note) {
                    $unsigned_notes[$key]->teacher = Teacher::getTeacherById($note->teacher_id)->teacher_name;
                }

                $grades = DB::select('
SELECT * FROM `grades` as g LEFT JOIN `students` ON g.student_id = students.student_id LEFT JOIN `subjects` ON subjects.subject_id = g.subject_id LEFT JOIN `teachers` ON teachers.teacher_id = g.teacher_id where g.student_id = ? and g.signed = 0', [$student->student_id]);
                foreach ($grades as $key => $value) {
                    $grades[$key]->grade_name = directorGrade::find($value->grade)->grade_name;
                    $grades[$key]->grade_number = directorGrade::find($value->grade)->grade_number;

                }
                $class = DB::select('SELECT * FROM `classes` LEFT JOIN students_classes ON classes.class_id = students_classes.class_id WHERE
students_classes.student_id = ? LIMIT 1', [$student->student_id])[0];
                return view('parent', ['student' => $student, 'parent' => $parent, 'class' => $class, 'unsigned_notes' => $unsigned_notes, 'grades' => $grades]);
            }


        } else {
            $types_user = $user_model->getUserTypes();
            return view('login_form', ['types_user' => $types_user]);
        }
    }

    public function processData(Request $request)
    {
        $validate = $this->validate($request, [
            'username' => 'min:5',
            'password' => 'min:5',
            'type' => 'numeric'
        ],
            [
                'type.numeric' => 'Error',
            ]);

        if ($validate['username'] == env('DIRECTOR_USERNAME') && $validate['password'] == env('DIRECTOR_PASSWORD')) {
            $request->session()->put('user_data', ['type' => 'director']);
            $request->session()->put('islogged', true);
            return redirect()->route('home');

        }
        $user = DB::select('SELECT * FROM `users` WHERE `username` = ? and `type` = ?',
            [$validate['username'], $validate['type']]);

        if (count($user) == 1 && password_verify($validate['password'], $user[0]->password)) {
            $user_model = new Models\User();
            unset($validate['password']);
            $user_data['id'] = $user[0]->user_id;
            $user_data['tid'] = $user[0]->id;
            $user_data['username'] = ucfirst(strtolower($validate['username']));
            $user_data['type'] = $user_model->getUserTypes()[$validate['type']];
            $request->session()->put('user_data', $user_data);
            $request->session()->put('islogged', true);
            return redirect()->route('home');
        } else {
            return view('error', ['type_error' => 'No such that user in database']);
        }

    }


    public function logout(Request $request)
    {
        $request->session()->put('user_data', null);
        $request->session()->put('islogged', false);
        return redirect(url('/'));
    }

    public function changePasswordForm(Request $request)
    {
        if ($request->session()->get('islogged') !== true) {
            return redirect()->route('home');
        }

        return view('changepassword');
    }

    public function changePassword(Request $request)
    {
        $validate = $this->validate($request,[
            'password' => 'min:8',
            'new' => 'min:8',
            'repeat' => 'same:new'
        ]);


        $this->logout($request);
    }


}