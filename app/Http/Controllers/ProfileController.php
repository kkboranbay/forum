<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'userProfile' => $user,
            'activities'  => $this->getActivities($user),
        ]);
    }

    public function getActivities($user)
    {
        return $user->activities()->latest()->with('subject')
            ->take(50)->get()->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
