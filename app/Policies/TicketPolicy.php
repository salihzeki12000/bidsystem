<?php

namespace App\Policies;

use App\User;
use App\Ticket;
use App\TicketCategory;
use App\TicketAdminEmail;

class TicketPolicy
{
    public function before($user, $ability)
    {
        if($user->type == 'globe_admin' || $user->type == 'super_admin'){
            return true;
        }
    }

    /**
     * Determine if the given user can edit ticket settings.
     */
    public function change_settings($user)
    {
        $check = false;
        if($user->type == 'globe_admin'){
            $check = true;
        }

        return $check;
    }

    /**
     * Determine if the given user can view ticket.
     */
    public function ownership(User $user, Ticket $ticket)
    {
        if($user->type == 'globe_admin'){
            return true;
        }
        return $user->company_id == $ticket->company_id;
    }

    /**
     * Determine if the given ticket category can be deleted by the user.
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