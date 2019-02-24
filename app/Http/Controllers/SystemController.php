<?php

namespace App\Http\Controllers;


class SystemController
{
    public function getTime()
    {
        return date("d.m.Y H:i:s");
    }
}