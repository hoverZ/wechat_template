<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/19
 * Time: 14:52
 */

namespace App\Http\Middleware;


use Tymon\JWTAuth\Middleware\BaseMiddleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class GetUserFormToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', ['message' => 'token_not_provided', 'status_code' => 400], 400);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', ['message' => 'token_expired', 'status_code' => 401], $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', ['message' => 'token_invalid', 'status_code' => 401], $e->getStatusCode(), [$e]);
        }

        if (! $user) {
            return $this->respond('tymon.jwt.user_not_found', ['message' => 'user_not_found', 'status_code' => 401], 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }

    public function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);
        return $response ?: $this->response->json($error, $status);
    }
}