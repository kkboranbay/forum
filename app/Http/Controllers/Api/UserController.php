<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $search = \request('name');

        return User::select('name')
            ->where('name', 'LIKE', "$search%")
            ->take(5)
            ->get();
    }
}
