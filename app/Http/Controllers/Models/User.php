<?php

namespace App\Http\Controllers\Models;


class User
{
    public function getUserTypes() : array
    {
        return ['Teacher', 'Parent', 'Student'];
    }
}