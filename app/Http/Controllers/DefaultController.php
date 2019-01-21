<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('islogged', false)) {
            return 'Logged';
        } else {
            $types_user = ['Teacher', 'Parent', 'Student'];
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