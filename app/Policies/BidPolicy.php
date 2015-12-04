<?php

namespace App\Policies;

use App\User;
use App\Bid;

class BidPolicy
{
    public function before($user, $ability)
    {
        if($user->type == 'super_admin'){
            return true;
        }
    }


    /**
     * Determine if the given company can create bid.
     */
    public function create(User $user)
    {
        $check = false;
        if($user->type != 'inward_group_user' && $user->type != 'inward_group_admin' && $user->type != 'globe_admin'){
            $check = true;
        }
        return $check;
    }

    /**
     * Determine if the given bid can be updated by the user.
     */
    public function ownership(User $user, Bid $bid)
    {
        if($user->type == 'globe_admin'){
            return true;
        }
        return $user->company_id == $bid->company_id;
    }

    /**
     * Determine if the given bid can be deleted by the user.
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
