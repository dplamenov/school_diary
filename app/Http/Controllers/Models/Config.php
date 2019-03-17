<?php

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    public $timestamps = false;

}