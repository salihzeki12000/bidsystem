<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;

class SessionTimeout
{
    protected $session;
    protected $timeout=3600;

    public function __construct(Store $session){
        $this->session=$session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(!$this->session->has('lastActivityTime'))
                $this->session->put('lastActivityTime',time());
            elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
                $this->session->forget('lastActivityTime');
                Auth::logout();
                \Session::flash('alert_message', 'You had no activity in the last '.$this->timeout/60 .' minutes.');
                return redirect('/');
            }
            $this->session->put('lastActivityTime',time());
        }

        return $next($request);
    }
}
