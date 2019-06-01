<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Classes;
use App\Http\Controllers\Models\Config;
use App\Http\Controllers\Models\directorGrade;
use App\Http\Controllers\Models\Grade;
use App\Http\Controllers\Models\Students;
use App\Http\Controllers\Models\Subject;
use App\Http\Controllers\Models\Teacher;
use App\Http\Controllers\Models\User;
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
            return view('error', ['type_error' => 'Teacher already exists']);
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

        return view('classinfo', ['class_name' => $class_name, 'students' => $all_students, 'class_id' => $class_id]);
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

    public function addStudentForm(Request $request, $class_id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $class = new Classes();
        try {
            $class_name = $class->getClassNameById($class_id);
        } catch (\Exception $exception) {
            return view('error', ['type_error' => $exception->getMessage()]);
        }
        return view('addstudent', ['class_id' => $class_id, 'class_name' => $class_name]);
    }

    public function addStudent(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $validate = $this->validate($request, [
            'student_name' => 'min:5',
            'student_email' => 'email',
            'class_id' => 'numeric'
        ]);

        $student = new Students();
        $student->student_name = $validate['student_name'];
        $student->save();

        $user = new User();
        $user->username = strtolower(str_replace(' ', '', $validate['student_name']));
        $user->password = password_hash(strtolower(str_replace(' ', '', $validate['student_name'])), PASSWORD_BCRYPT);
        $user->email = $validate['student_email'];
        $user->type = 2;
        $user->id = $student->student_id;
        $user->save();

        DB::insert("INSERT INTO `students_classes` (`class_id`, `student_id`) VALUES (?, ?)", [$validate['class_id'], $user->id]);

        return redirect()->action('DirectorController@classInfo', ['id' => $validate['class_id']]);
    }

    public function deleteStudent(Request $request, $student_id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $user = User::where('id', $student_id)->first();
        Students::find($student_id)->delete();
        $user->delete();
        DB::delete('DELETE FROM grades where student_id = ?', [$user->user_id]);
        DB::delete('DELETE FROM students_classes where student_id = ?', [$student_id]);
        return redirect()->route('home');
    }

    public function editStudentForm(Request $request, $student_id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $student = new Students();
        $student = $student->getStudentById($student_id);

        $user = User::where('id', $student->student_id)->where('type', 2)->first();

        return view('editstudent', ['student' => $student, 'user' => $user]);
    }

    public function editStudent(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $validate = $this->validate($request, [
            'name' => 'min:8',
            'email' => 'email',
            'user_id' => 'numeric'
        ]);

        $user = User::find($validate['user_id']);
        $user->email = $validate['email'];
        $user->username = strtolower(str_replace(' ', '', $validate['name']));
        $user->password = password_hash(strtolower(str_replace(' ', '', $validate['name'])), PASSWORD_BCRYPT);
        $user->save();

        $student = Students::find($user->id);
        $student->student_name = $validate['name'];
        $student->save();
        return redirect()->route('home');

    }

    public function editSubjectForm(Request $request, $subject_id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        if (Subject::isSubjectExists($subject_id)) {
            $subject = Subject::find($subject_id);
            return view('editsubject', ['subject' => $subject]);
        } else {
            return view('error', ['type_error' => 'Subject does`t exits.']);
        }


    }

    public function editSubject(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $validate = $this->validate($request, [
            'subject_id' => 'numeric',
            'subject' => 'min:2'
        ]);

        $subject = Subject::find($validate['subject_id']);
        $subject->subject_name = $validate['subject'];
        $subject->save();

        return redirect()->route('home');
    }

    public function editTeacherForm(Request $request, $id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $teacher = Teacher::find($id);
        $user = User::where('id', $teacher->teacher_id)->where('type', 0)->first();
        return view('editteacher', ['teacher' => $teacher, 'user' => $user]);
    }

    public function editTeacher(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $validate = $this->validate($request, [
            'name' => 'min:5',
            'email' => 'email',
            'teacher_id' => 'numeric'
        ]);

        $teacher = Teacher::find($validate['teacher_id']);
        $user = User::find($teacher->teacher_id);

        $user->email = $validate['email'];
        $user->password = password_hash(strtolower(str_replace(' ', '', $validate['name'])), PASSWORD_BCRYPT);
        $user->username = strtolower(str_replace(' ', '', $validate['name']));
        $user->save();
        $teacher->teacher_name = $validate['name'];
        $teacher->save();

    }

    public function schoolInfo(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }

        $config = Config::all();

        $teacher_count = count(Teacher::all());
        $subject_count = count(Subject::all());
        return view('schooinfo', ['config' => $config, 'teacher_count' => $teacher_count, 'subject_count' => $subject_count]);
    }

    public function schoolInfoEditForm($id)
    {
        $config = Config::find($id);

        return view('editinfo', ['config' => $config]);
    }

    public function schoolInfoEdit(Request $request)
    {
        $validate = $this->validate($request, [
            'value' => 'min:3',
            'id' => 'required'
        ]);
        $config = Config::find(intval($validate['id']));
        $config->value = $validate['value'];
        $config->save();

        return redirect()->to('director/schoolinfo');
    }

    public function deleteClass($class_id)
    {
        $students = DB::select('SELECT * FROM students_classes where class_id = ?', [$class_id]);

        foreach ($students as $_student) {

            $student = Students::find($_student->student_id);
            $student->delete();
        }
        $class = Classes::find($class_id);
        $class->delete();

        redirect()->route('home');
    }

    public function studentInfo(Request $request, $id)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $student = Students::find($id);
        $class = DB::select('SELECT * FROM students_classes LEFT JOIN classes ON classes.class_id = students_classes.class_id WHERE students_classes.student_id = ?', [$id]);

        $studentGrade = Grade::where('student_id', $id)->get();
        foreach ($studentGrade as $key => $grade){
            $studentGrade[$key]->subject = Subject::find($grade->subject_id)->subject_name;
        }

        return view('director_student', ['student' => $student, 'class' => $class[0]->class_name]);
    }
}