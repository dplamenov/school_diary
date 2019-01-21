<?php

namespace App\Http\Controllers\Models;


class User
{
    public function getUserTypes()
    {
        return ['Teacher', 'Parent', 'Student'];
    }
}