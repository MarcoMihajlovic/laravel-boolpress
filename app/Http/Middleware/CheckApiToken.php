<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckApiToken
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
        $auth_token = $request -> header('Authorization');

        //Verifico se è present il nostro API Token
        if(empty($auth_token)) {
            return response() -> json([
                'success' => false,
                'error' => 'Api Token Missed'
            ]); 
        }

        //tolgo il pre stringa da token
        $api_token = substr($auth_token, 7);
        $user = User::where('api_token', $api_token) -> first();
        
        //controlliamo se l'Api token è giusto
        if(!$user) {
            return response() -> json([
                'success' => false,
                'error' => 'Wrong Api Token'
            ]); 
        }

        return $next($request);
    }
}
