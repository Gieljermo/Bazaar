<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;
class CheckUserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  ...$roleNames): Response
    {
        foreach ($roleNames as $roleName) {
            if (Auth::check() && (Role::find(Auth::user()->role_id))->role_name == $roleName) {
                return $next($request);
            }
        }

        return redirect('login');
    }
}
