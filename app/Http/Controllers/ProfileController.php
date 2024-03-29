<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'userProfile' => $user,
            'activities'  => Activity::feed($user),
        ]);
    }
}
