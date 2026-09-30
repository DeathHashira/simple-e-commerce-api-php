<?php

namespace Security;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT
{
    public static function encode(array $payload): string
    {
        $key = JWT::loadSecretFromEnv();
        $token = FirebaseJWT::encode($payload, $key, "HS256");

        return $token;
    }

    public static function decode(string $token): array
    {
        $key = JWT::loadSecretFromEnv();
        $payload = FirebaseJWT::decode($token, new Key($key, "HS256"));
        
        return (array) $payload;
    }

    private static function loadSecretFromEnv(): string
    {
        return $_ENV["JWT_SECRET"];
    }
}
