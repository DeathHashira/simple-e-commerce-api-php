<?php

namespace Middleware;

use App\Http\Request;
use App\Http\Response;

class Auth
{
    public static function handle(Request $request, callable $next): void
    {
        $headers = $request->getHeaders();
        if (empty($headers["Authorization"])) {
            (new Response())
            ->setStatusCode(401)
            ->send();
        } else {
            $next();
        }
    }
}
