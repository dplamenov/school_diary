<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return redirect()->route('home');
    }

    public function signed($id)
    {
        if (Models\Note::isNoteExists($id)) {
            $note = Models\Note::find($id);
            $note->signed = 1;
            $note->save();
        } else {
            return view('error', ['type_error' => 'Error']);
        }
        return redirect()->route('home');
    }

    public function signedGrade(Request $request, $id)
    {

        if ($request->session()->get('user_data')['type'] != 'Parent') {
            return redirect()->route('home');
        }
        $grade = Models\Grade::find($id);
        if ($grade) {
            if ($grade->count() > 0) {
                $id = $request->session()->get('user_data')['tid'];
                $parent = Models\Parents::where('parent_id', '=', $id)->where('student_id', '=', $grade->student_id)->get();
                if (count($parent) > 0) {
                    $grade->signed = 1;
                    $grade->save();
                    return redirect()->route('home');
                }
            }
        }
        return view('error', ['type_error' => 'Error']);



    }
}
