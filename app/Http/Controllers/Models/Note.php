<?php

namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'note_id';
    public $timestamps = false;

    public static function isNoteExists($note_id)
    {
        $r = DB::select('SELECT COUNT(*) as count FROM `notes` WHERE `note_id` = ' . $note_id);
        return (boolean)$r[0]->count;
    }
}