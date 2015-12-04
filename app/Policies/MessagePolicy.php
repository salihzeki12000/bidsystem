<?php

namespace App\Policies;

use App\User;
use App\Message;

class MessagePolicy
{
    public function before($user, $ability)
    {
        if($user->type == 'super_admin'){
            return true;
        }
    }

    /**
     * Determine if the given user can create new message.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine if the given user can view and edit all messages.
     */
    public function list_messages(User $user)
    {
        $check = false;
        if($user->type == 'globe_admin'){
            $check = true;
        }
        return $check;
    }

    /**
     * Determine if the given message can be updated by the user.
     */
    public function update(User $user, Message $message)
    {
        if($user->type == 'globe_admin'){
            return true;
        }
        return $user->company_id == $message->sender;
    }

    /**
     * Determine if the given message can be deleted by the user.
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