<?php

namespace Services;

use Model\UsersRepo;
use Security\JWT;
use Src\Service;

class AuthService extends Service
{
    public function __construct(
        private UsersRepo $usersRepo
    ) {}

    public function addNewUser(string $username, string $email, string $password): array
    {
        $data = [
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ];

        $id = $this->usersRepo->create($data);
        $adminAccess = ($this->usersRepo->readById($id)[0]["admin_access"] == 1) ? true : false;

        if ($id) {
            return [
                "successful" => true,
                "token" => $this->createToken($id, $adminAccess)
            ];
        } else {
            return [
                "successful" => false
            ];
        }
    }

    public function login(string $email, string $password): array
    {
       $userInfo = $this->usersRepo->readByCondition(["email" => $email])[0];
       $hash = $userInfo["password"];
       $id = $userInfo["id"];
       $adminAccess = $userInfo["admin_access"];

       if (password_verify($password, $hash)) {
           return [
               "successful" => true,
               "token" => $this->createToken($id, $adminAccess)
           ];
       } else {
           return [
               "successful" => false
           ];
       }
    }

    private function createToken(int $id, bool $adminAccess): string
    {
        $payload = [
            'iss' => 'hashira-e-commerce',
            'sub' => $id,
            'admin' => $adminAccess,
            'iat' => time(),
            'exp' => time() + 3600
        ];

        return JWT::encode($payload);
    }
}
