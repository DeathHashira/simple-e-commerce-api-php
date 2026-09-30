<?php

namespace Services;

use Model\CartsRepo;
use Src\Service;

class CartService extends Service
{
   public function __construct(
        private CartsRepo $cartRepo
   ) {}

   public function addNewItem($token, $productId): array
   {
       $result = $this->validateToken($token);
       if (!$result["successful"]) {
           return $result;
       }

       $data = [
           "user_id" => $result["user_id"],
           "product_id" => $productId
       ];

       $id = $this->cartRepo->create($data);
       if ($id === 0) {
           return [
               "successful" => true
           ];
       } else {
           return [
               "successful" => false
           ];
       }
   }

   public function removeItem(string $token, int $productId): array
   {
       $result = $this->validateToken($token);
       if (!$result["successful"]) {
           return $result;
       }

       if ($this->cartRepo->deleteProduct($result["user_id"], $result["product_id"])) {
           return [
               "successful" => true
           ];
       } else {
           return [
               "successful" => false
           ];
       }
   }

   public function showCartProducts(string $token): array
   {
       $result = $this->validateToken($token);
       if (!$result["successful"]) {
           return $result;
       }
       $items = $this->cartRepo->showAllItems($result["user_id"]);
       if (!empty($items)) {
           return [
               "successful" => true,
               "items" => $items
           ];
       } else {
           return [
               "successful" => false
           ];
       }
   }
}
