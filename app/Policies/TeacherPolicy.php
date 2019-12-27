<?php

namespace App\Policies;

use App\Teacher;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Teacher $teacher)
    {
        return $user->is($teacher->user);
    }
}
