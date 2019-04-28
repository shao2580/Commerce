<?php

namespace App\Http\Middleware;

use Closure;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $name = $request->name;
        if (!$request->session()->get('name','$name')) {
            return redirect('/link/list');
        }
        return $next($request);
    }
}
