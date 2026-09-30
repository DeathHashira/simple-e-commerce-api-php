<?php

namespace Middleware;

use App\Http\Request;
use App\Http\Response;

class Guest
{
    public static function handle(Request $request, callable $next): void
    {
       $headers = $request->getHeaders();
       if (array_key_exists("Authorization", $headers)) {
           (new Response)
           ->setStatusCode(302)
           ->send();
       } else {
           $next();
       }
    }
}
