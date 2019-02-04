<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function registerParentForm(Request $request, int $id){
        $student = new Models\Students();
        if(!$student->studentExist($id)){
            return view('error', ['type_error' => 'Error']);
        }



        return view('registerparent', ['id' => $id]);

    }
}
