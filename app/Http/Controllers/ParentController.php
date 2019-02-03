<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function registerParent(Request $request, int $id){
        echo $id;
    }
}
