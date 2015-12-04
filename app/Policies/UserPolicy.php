<?php

namespace App\Policies;

use App\User;
use App\Company;

class UserPolicy
{
    public function before($user, $ability)
    {
        if($user->type == 'super_admin'){
            return true;
        }
    }

    /**
     * Determine if the given user can view users.
     */
    public function view_user_list(User $user)
    {
        $check = false;
        if($user->type == 'globe_admin'){
            $check = true;
        }

        return $check;
    }

    /**
     * Determine if the given user can create new user.
     */
    public function create(User $user)
    {
        $check = false;
        if($user->type == 'super_admin'){
            $check = true;
        }

        return $check;
    }

    /**
     * Determine if the given user can be deleted by the user.
     */
    public function delete(User $user)
    {
        $check = false;
        if($user->type == 'super_admin'){
            $check = true;
        }

        return $check;
    }

}