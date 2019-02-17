<?php


namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class directorGrade extends Model
{
    protected $table = 'grade';
    protected $primaryKey = 'grade_id';
    public $timestamps = false;

    public function isGradeExistsByName($grade_name)
    {
        $grade_name = "'$grade_name'";
        $r = DB::select('SELECT COUNT(*) as count FROM `grade` WHERE `grade_name` = ' . $grade_name);
        return (boolean)$r[0]->count;
    }
}