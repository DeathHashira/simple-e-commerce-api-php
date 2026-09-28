<?php

namespace Controllers;

use App\Http\Response;
use Services\CartService;
use Src\Controller;

class CartController extends Controller
{
    public function __construct(
        $request,
        private CartService $cartService
    ) {
        parent::__construct($request);
    }

    public function addItem(): Response
    {
        $token = $this->getToken();
        [$productId] = $this->parseElements($this->request->postBody(), ["product_id"]);
        $result = $this->cartService->addNewItem($token, $productId);

        if ($result["successful"]) {
            return (new Response())
            ->setHeader("Location", "/cart");
        } else {
            return (new Response())
            ->setStatusCode(400);
        }
    }

    public function removeItem(): Response
    {
       $token = $this->getToken();
       [$productId] = $this->parseElements($this->request->postBody(), ["product_id"]);

       $result = $this->cartService->removeItem($token, $productId);
       if ($result["successful"]) {
           return (new Response())
           ->setHeader("Location", "/cart");
       } else {
           return (new Response())
           ->setStatusCode(400);
       }
    }

    public function showList(): Response
    {
        $token = $this->getToken();
        $result = $this->cartService->showCartProducts($token);

        if ($result["successful"]) {
            return (new Response())
            ->setHeader("Content-type", "application/json")
            ->setContent($result["items"]);
        } else {
            return (new Response())
            ->setStatusCode(400);
        }
    }
}
