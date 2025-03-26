<?php

namespace App\Policies;

use App\Models\Jury;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JuryPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isAdmin();
    }
}
