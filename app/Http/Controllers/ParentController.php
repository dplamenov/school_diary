<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Parents;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function registerParent(Request $request, int $id){
        $parent = new Parents();
        $parent->parentExist($id);
    }
}
