<?php

namespace App\Policies;

use App\Session;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Session $session)
    {
        return $user->is($session->user);
    }

}
