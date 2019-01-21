<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController
{
    public function index(Request $request)
    {
        if ($request->session()->get('islogged', false)) {
            return 'Logged';
        } else {
            return view('login_form');
        }
    }

    public function processData(Request $request){

    }
}