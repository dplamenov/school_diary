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
            //return 'Logged';
            return view('logged', ['user_data' => $request->session()->get('user_data')]);
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


        $user = DB::select('SELECT * FROM `users` WHERE `username` = ? and `password` = ? and `type` = ?',
            [$validate['username'], $validate['password'], $validate['type']]);
        if(count($user) == 1){
            unset($validate['password']);
            $request->session()->put('user_data', $validate);
            $request->session()->put('islogged', true);
            return redirect('/');
        }else{
            return view('error',['type_error' => 'No such that user in database']);
        }

    }

    public function logout(Request $request){
        $request->session()->put('user_data', null);
        $request->session()->put('islogged', false);
        return redirect(url('/'));
    }
}