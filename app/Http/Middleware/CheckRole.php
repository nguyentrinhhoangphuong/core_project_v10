<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Kiểm tra nếu người dùng có vai trò phù hợp qua AuthServiceProvider
        if (Gate::allows($role)) {
            return $next($request);
        }
        // Chuyển hướng người dùng không có vai trò phù hợp
        return redirect()->route('frontend.home.index');
    }
}
