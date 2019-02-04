<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function registerParentForm(int $id)
    {
        $student = new Models\Students();
        if (!$student->studentExist($id)) {
            return view('error', ['type_error' => 'Error']);
        }

        return view('registerparent', ['id' => $id]);
    }

    public function registerParent(Request $request, int $id)
    {
        $this->validate($request,[
            'name' => 'min:5',
            'username' => 'min:4|max:18',
            'password' => 'min:8',
            'password_repeat' => 'same:password'
        ]);
    }
}
