<?php

namespace App\Policies;

use App\Company;
use App\User;

class CompanyPolicy
{

    public function before($user, $ability)
    {
        if($user->type == 'globe_admin' || $user->type == 'super_admin'){
            return true;
        }
    }

    /**
     * Determine if the given company can create job.
     */
    public function create(User $user)
    {
        $check = false;
        if($user->type == 'globe_admin' && $user->type == 'super_admin'){
            $check = true;
        }
        return $check;
    }

    /**
     * Determine if the given company can be updated by the user.
     */
    public function edit(User $user, Company $company)
    {
        return $user->company_id == $company->id && $company->delete == "0";
    }

    /**
     * Check company type.
     */
    public function outsourcer(User $user, Company $company)
    {
        return $user->company_id == $company->id && $company->delete == "0" && $company->category == "Outsourcing";
    }

    /**
     * Check company type.
     */
    public function lsp(User $user, Company $company)
    {
        return $user->company_id == $company->id && $company->delete == "0" && $company->category == "LSP";
    }

    /**
     * Determine if the given company file can be updated by the user.
     */
    public function company_file(User $user, $comapny_id)
    {
        return $user->company_id == $comapny_id;
    }

    /**
     * Determine if the given user can view user list.
     */
    public function ownership(User $user, Company $company)
    {
        if($user->type == 'globe_admin'){
            return true;
        }
        return $user->company_id == $company->id;
    }

    /**
     * Determine if the given company can be updated by the user.
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
     * Determine if the user belongs to given company and the company is outsourcer.
     */
    public function check_incoming_bids(User $user, Company $company)
    {
        return $user->company_id == $company->id && $company->category == 'Outsourcing' && $company->delete == "0";
    }

}
