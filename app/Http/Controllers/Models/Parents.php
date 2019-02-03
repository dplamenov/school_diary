<?php

namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parents';
    protected $primaryKey = 'parent_id';
    public $timestamps = false;

}
