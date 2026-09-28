<?php

namespace Middleware;

use App\Http\Request;
use App\Http\Response;

class Auth
{
    public function __construct(
        public Request $request
    ) {}

    public function handle()
    {
        $headers = $this->request->getHeaders();
        if (empty($headers["Authorization"])) {
            (new Response())
            ->setStatusCode(401)
            ->send();
        }
    }
}
