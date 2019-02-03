<?php

namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;

    public function studentExist(int $id)
    {
        return (bool)Students::where('student_id', $id)->get();
    }
}
