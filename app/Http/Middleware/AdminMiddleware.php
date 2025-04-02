<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu user chưa đăng nhập hoặc không phải là admin thì 
        // sẽ quay ngược lại trang client
        if (!Auth::check() || !Auth::user()->isRoleAdmin()) {
            return redirect()->route('welcome')
                    ->with('error', 'Bạn ko có quyền truy cập vào trang admin');
        }
        return $next($request);
    }
}
