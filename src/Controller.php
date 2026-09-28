<?php

namespace Src;

use App\Http\Request;

class Controller
{
    public function __construct(
        protected Request $request
    ) {}

    protected function parseElements(array $params, array $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[] = $params[$key];
        }

        return $result;
    }

    protected function getToken(): string
    {
        $headers = $this->request->getHeaders();
        return explode(" ", $headers["Authorization"])[1];
    }
}
