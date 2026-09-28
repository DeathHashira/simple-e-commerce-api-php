<?php

namespace Controllers;

use App\Http\Request;
use App\Http\Response;
use Services\AuthService;
use Src\Controller;

class AuthController extends Controller
{
   public function __construct(
        private Request $request,
        private AuthService $authService
   ) {}

   public function registerNewUser(): Response
   {
       [$username, $email, $password] = $this->parseElements(
            $this->request->postBody(),
            ["username", "email", "password"]
       );
       $result = $this->authService->addNewUser($username, $email, $password);

       if ($result["successful"]) {
           return (new Response)
           ->setContent([
               "access_token" => $result["token"]
           ])
           ->setHeader("Content-type", "application/json")
           ->setHeader("Location", "/");
       } else {
           return (new Response)
           ->setStatusCode(400);
       }
   }

   public function login(): Response
   {
       [$email, $password] = $this->parseElements($this->request->postBody(), ["email", "password"]);
       $result = $this->authService->login($email, $password);

       if ($result["successful"]) {
           return (new Response())
           ->setContent([
               "access_token" => $result["token"]
           ])
           ->setHeader("Content-type", "application/json")
           ->setHeader("Location", "/");
       } else {
           return (new Response())
           ->setStatusCode(400);
       }
   }
}
