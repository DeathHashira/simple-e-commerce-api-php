<?php

namespace Controllers;

use App\Http\Response;
use Services\AdminService;
use Src\Controller;

class ProductController extends Controller
{
   public function __construct(
        $request,
        private AdminService $admingService
   ) {
        parent::__construct($request);
   }

   public function addProduct(): Response
   {
       $token = $this->getToken();
       [$productName, $productAmount, $productQuantity, $productCategory] = $this->parseElements(
       $this->request->postBody(),
       ["name", "amount", "quantity", "category"]);
       $result = $this->admingService->addNewProduct($token, $productName, $productAmount, $productQuantity, $productCategory);

       if ($result["successful"]) {
           return (new Response);
       } else {
           return (new Response)
           ->setStatusCode(400);
       }
   }

   public function deleteProduct(): Response
   {
       $token = $this->getToken();
       [$productId] = $this->parseElements($this->request->postBody(), ["id"]);
       $result = $this->admingService->deleteProductById($token, $productId);

       if ($result["successful"]) {
           return new Response();
       } else {
           return (new Response())
           ->setStatusCode(401);
       }
   }

   public function updateProduct(): Response
   {
       $token = $this->getToken();
       $data = $this->request->postBody();
       $result = $this->admingService->updateProductById($token, $data);

       if ($result["successful"]) {
           return new Response();
       } else {
           return (new Response())
           ->setStatusCode(401);
       }
   }
}
