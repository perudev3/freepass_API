<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use App\User;
use Closure;

class MainMiddleware
{
    protected  $auth;
    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        
        /* if ($this->auth->check()) {
            if ($user->session_user == NULL) {
                User::where('id', $user->id )->update([ 'session_user' => $token_session ]);
                    switch($user->id_rol)
                    {
                            case '1':
                            return Redirect::to('cpanel');
                            break;
                            case '2':
                                return Redirect::to('cpanel');
                                break;
                            default:
                            return Redirect::to('/');
                            break;
                    }
            }else{
                \Auth::logout();
                return Redirect::to('session_init')->with('message', 'ya inicio sesion');
            }
        } */

        $token_session = Cookie::get('freepass_session');
        $user = $this->auth->user();
        if ($this->auth->check()) {
            switch($user->id_rol)
            {
                    case '1':
                        return Redirect::to('cpanel');
                        break;
                    case '2':
                        return Redirect::to('cpanel');
                        break;
                    default:
                    return Redirect::to('/');
                        break;
            }
        }

        return $next($request);
    }

}
