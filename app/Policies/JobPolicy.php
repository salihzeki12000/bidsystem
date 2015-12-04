<?php

namespace App\Policies;

use App\User;
use App\Job;

class JobPolicy
{
    public function before($user, $ability)
    {
        if($user->type == 'super_admin'){
            return true;
        }
    }

    /**
     * Determine if the given company can create job.
     */
    public function create(User $user)
    {
        $check = false;
        if($user->type != 'outward_group_user' && $user->type != 'outward_group_admin' && $user->type != 'globe_admin'){
            $check = true;
        }
        return $check;
    }

    /**
     * Determine if the given job can be updated by the user.
     */
    public function ownership(User $user, Job $job)
    {
        if($user->type == 'globe_admin'){
            return true;
        }
        return $user->company_id == $job->company_id;
    }

    /**
     * Determine if the given job can be deleted by the user.
     */
    public function delete(User $user)
    {
        $check = false;
        if($user->type == 'super_admin'){
            $check = true;
        }

        return $check;
    }


    /**
     * Determine if the given user can search jobs.
     */
    public function search(User $user)
    {
        $check = false;
        if($user->type == 'outward_group_user' || $user->type == 'outward_group_admin'){
            $check = true;
        }
        return $check;
    }
}