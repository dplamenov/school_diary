<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function index(Request $request)
    {
        $user_model = new Models\User();
        if ($request->session()->get('islogged', false)) {
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
            return view('director', ['user_data' => ['type' => 'director']]);

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
            return view(strtolower($user_data['type']), ['user_data' => $user_data]);
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

    public function teacher(Request $request)
    {

        return view('teacher');
    }
}