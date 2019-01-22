<?php


namespace App\Http\Controllers\Models;

use Illuminate\Support\Facades\DB;

class Subject
{
    public function getAllSubject()
    {
        $subject = DB::select('SELECT * FROM `subjects`');
        foreach ($subject as $item){
            yield $item;
        }
    }
}