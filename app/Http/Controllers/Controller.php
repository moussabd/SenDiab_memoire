<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function getUserId()
    {
        return Auth::id();
    }
}
