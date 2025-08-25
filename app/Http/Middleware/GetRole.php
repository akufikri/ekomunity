<?php

namespace App\Http\Middleware;

use Closure;

class GetRole
{
    public function handle($request, Closure $next)
    {
        // Get the required roles from the route
        $roles = $this->getRequiredRoleForRoute($request->route());
        // Check if a role is required for the route, and
        // if so, ensure that the user has that role.
        if($request->user()->hasRole($roles, $request->route()) || !$roles)
        {
            return $next($request);
        }
        $title = "UNAUTHORIZED";
        $error_code = 401;
        $message_title = "INSUFFICIENT ROLE.";
        $message = 'You are not authorized to access this resource.';
        
        // return response()->view('errors.error', compact('title', 'error_code', 'message_title', 'message'));
        return response([
            'error' => [
                // 'role' => $request->user()->getUserRole($request->route()),
                // 'access_list' => $request->user()->getAccessList($request->route()),
                'code' => 'INSUFFICIENT_ROLE',
                'description' => 'You are not authorized to access this resource.'
            ]
        ], 401);
    }
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}