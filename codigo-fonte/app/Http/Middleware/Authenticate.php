<?php
namespace App\Http\Middleware;

use Closure;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate {

    public function handle($request, Closure $next, ...$guards) {

        $uri = app('router')->current()->getUri();
        
        if(!preg_match('/^(login|register|logout|password)/', $uri)) {
            
           $this->authenticate($guards);
        }
                
        return $next($request);
    }
}