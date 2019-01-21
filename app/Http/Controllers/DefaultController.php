<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function index(Request $request)
    {
        echo '<pre>' . print_r(DB::select('SELECT * FROM `users`'), true) . '</pre>';
        $user_model = new Models\User();
        if ($request->session()->get('islogged', false)) {
            return 'Logged';
            //return view('logged');
        } else {
            $types_user = $user_model->getUserTypes();
            return view('login_form', ['types_user' => $types_user]);
        }
    }

    public function processData(Request $request)
    {
        $validate = $this->validate($request, [
            'username' => 'min:5',
            'password' => 'min:8',
            'type' => 'numeric'
        ],
            [
                'type.numeric' => 'Error',
            ]);



        echo '<pre>' . print_r($validate, true) . '</pre>';
        echo '<pre>' . print_r($request->post(), true) . '</pre>';
    }
}