<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class TeamPolicy
{
    use HandlesAuthorization;


    public function register(User $user): bool
    {
        return $user->isCompetitor();
    }
}
