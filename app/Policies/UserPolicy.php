<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $signedInUser
     * @param User $userProfile
     * @return bool
     */
    public function update(User $signedInUser, User $userProfile)
    {
        return $signedInUser->id === $userProfile->id;
    }
}
