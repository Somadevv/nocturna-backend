<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JWTMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   *
   * @return Response|RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    $cookie_name = 'NocturnaCookie';
    if (!$request->bearerToken()) {
      if ($request->hasCookie($cookie_name)) {
        $token = $request->cookie($cookie_name);
        $request->headers->add([
          'Authorization' => 'Bearer ' . $token
        ]);
      }
    }

    if ($request->bearerToken()) {
      return $next($request);
    }

    return response('Unauthorised', 401);
  }
}
