<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function index(Request $request)
    {
        $user_model = new Models\User();
        if ($request->session()->get('islogged', false)) {
            if ($request->session()->get('user_data')['type'] == 'director') {
                $subject_model = new Subject();
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

                $all_subject = $subject_model->getAllSubject();
                return view(strtolower($request->session()->get('user_data')['type']), ['user_data' => $request->session()->get('user_data'), 'teachers' => $result, 'subjects' => $all_subject]);
            }elseif (strtolower($request->session()->get('user_data')['type']) == 'teacher'){
                echo '<pre>' . print_r($request->session()->all(), true) . '</pre>';
            }

            return view(strtolower($request->session()->get('user_data')['type']), ['user_data' => $request->session()->get('user_data')]);
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

        if ($validate['username'] == 'admin' && $validate['password'] == 'admin') {
            $request->session()->put('user_data', ['type' => 'director']);
            $request->session()->put('islogged', true);
            return redirect()->route('home');

        }

        $user = DB::select('SELECT * FROM `users` WHERE `username` = ? and `password` = ? and `type` = ?',
            [$validate['username'], $validate['password'], $validate['type']]);
        if (count($user) == 1) {
            $user_model = new Models\User();
            unset($validate['password']);
            $user_data['username'] = ucfirst(strtolower($validate['username']));
            $user_data['type'] = $user_model->getUserTypes()[$validate['type']];
            $request->session()->put('user_data', $user_data);
            $request->session()->put('islogged', true);
            return redirect()->route('home');
        } else {
            return view('error', ['type_error' => 'No such that user in database']);
        }
    }

    public
    function logout(Request $request)
    {
        $request->session()->put('user_data', null);
        $request->session()->put('islogged', false);
        return redirect(url('/'));
    }

    public function teacher(Request $request)
    {

        return view('teacher');
    }


}