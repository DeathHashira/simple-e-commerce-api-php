<?php

namespace Src;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Security\JWT;
use Throwable;

class Service
{
    private function parseToken(array $payload): array
    {
        $userId = $payload["sub"];
        $adminAccess = $payload["admin"];

        return [
            "user_id" => $userId,
            "admin_access" => $adminAccess
        ];
    }

    protected function validateToken(string $token): array
    {
        try {
            $payload = JWT::decode($token);
            $result = ["successful" => true];
            $result += $this->parseToken($payload);

            return $result;

        } catch (SignatureInvalidException | ExpiredException $e) {
            return [
                "successful" => false,
                "error" => "unauthorization"
            ];
        } catch (Throwable $e) {
            return [
                "successful" => false,
                "error" => "server"
            ];
        }
    }
}
