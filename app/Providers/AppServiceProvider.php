<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('view')->composer('app', function($view)
        {
            $action = app('request')->route()->getAction();

            $controller = class_basename($action['controller']);

            list($controller, $action) = explode('@', $controller);

            $collapse = true;
            if(in_array($action, ['jobProgressTracking', 'jobHistory','bidProgressTracking', 'bidHistory']) || (in_array($controller, ['JobsController', 'BidsController']) && in_array($action, ['create', 'index'])) ){
                $collapse = false;
            }

            $view->with(compact('controller', 'action', 'collapse'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
