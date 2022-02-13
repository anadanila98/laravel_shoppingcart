<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Session;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            //stocam url-ul pe are utilizatorul vroia sa il acceseze inainte sa il redirectionam pur si simplu
            //Session::put('oldUrl', $request->url());
            //return redirect()->route('user.signin'); //asa nu merge sa redirectioneze catre signin de la checkout (nu inteleg de ce)
            return route('user.signin');
        }
        else {
            return response('Unauthorized.', 401);
        }

    }

    /*public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            else {
                return redirect()->route('user.signin');
            }
        }

        return $next($request);
    }*/
}
