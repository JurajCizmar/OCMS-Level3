<?php namespace AppChat\Chat\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use AppChat\Chat\Classes\Services\UserService;
use October\Rain\Exception\NotFoundException as NotFoundException;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = UserService::getTokenFromAuth($request);

        if (!$token) {

            throw new NotFoundException('Authorization failed');

        } 
        else {
            $user = UserService::getUserByToken($token);
        }

        return $next($request);
    }
}