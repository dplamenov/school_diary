<?php

namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'note_id';
    public $timestamps = false;
}