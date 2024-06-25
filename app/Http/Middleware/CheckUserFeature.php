<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserFeature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$features)
    {
        $user = Auth::user();

        if ($user){
            foreach ($features as $feature) {
                [$enumClass, $enumValue] = explode('-', $feature);
                $enumValueInstance = constant("$enumClass::$enumValue");

                if ($user->hasFeature($enumValueInstance)) {
                    return $next($request);
                }
            }
        }
        return redirect('/');
    }
}
