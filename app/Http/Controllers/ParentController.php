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
        $name = $student->getStudentById($id)->student_name;
        return view('registerparent', ['id' => $id, 'student_name' => $name]);
    }

    public function registerParent(Request $request, int $student_id)
    {
        $validate = $this->validate($request, [
            'name' => 'min:5',
            'username' => 'min:5|max:18',
            'password' => 'min:8',
            'password_repeat' => 'same:password',
            'email' => 'email'
        ]);

        $validate['student_id'] = $student_id;
        $parent_model = new Models\Parents();
        $parent_model->newParent($validate);
    }
}
