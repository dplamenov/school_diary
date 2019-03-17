<?php
/**
 * Project: school_diary.
 * File: Config.php
 * Developer: dplamenov@icloud.com
 * Date: 17.3.2019 г.
 * Time: 9:12
 */

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    public $timestamps = false;

}