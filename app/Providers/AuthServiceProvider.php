<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Company' => 'App\Policies\CompanyPolicy',
        'App\Job' => 'App\Policies\JobPolicy',
        'App\Bid' => 'App\Policies\BidPolicy',
        'App\Message' => 'App\Policies\MessagePolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->define('super-admin-only', function ($user) {
            $check = false;
            if($user->type == 'super_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('globe-admin-above', function ($user) {
            $check = false;
            if($user->type == 'globe_admin' || $user->type == 'super_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('group-admin-above', function ($user) {
            $check = false;
            if($user->type != 'inward_group_user' && $user->type != 'outward_group_user'){
                $check = true;
            }
            return $check;
        });

        $gate->define('inward-admin-above', function ($user) {
            $check = false;
            if($user->type != 'inward_group_user' &&  $user->type != 'outward_group_user' && $user->type != 'outward_group_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('outward-admin-above', function ($user) {
            $check = false;
            if($user->type != 'inward_group_user' &&  $user->type != 'outward_group_user' && $user->type != 'inward_group_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('non-system-admin', function ($user) {
            $check = false;
            if($user->type !== 'globe_admin' && $user->type !== 'super_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('inward-user-only', function ($user) {
            $check = false;
            if($user->type == 'inward_group_user' || $user->type == 'inward_group_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('outward-user-only', function ($user) {
            $check = false;
            if($user->type == 'outward_group_user' || $user->type == 'outward_group_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('non-inward-user', function ($user) {
            $check = false;
            if($user->type == 'outward_group_user' || $user->type == 'outward_group_admin' || $user->type == 'globe_admin' || $user->type == 'super_admin'){
                $check = true;
            }
            return $check;
        });

        $gate->define('non-outward-user', function ($user) {
            $check = false;
            if($user->type == 'inward_group_user' || $user->type == 'inward_group_admin' || $user->type == 'globe_admin' || $user->type == 'super_admin'){
                $check = true;
            }
            return $check;
        });
    }
}