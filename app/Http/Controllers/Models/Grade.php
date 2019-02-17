<?php


namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    protected $primaryKey = 'grade_id';
    public $timestamps = false;
}