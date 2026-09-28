<?php

namespace Services;

use Model\ProductsRepo;
use Src\Service;

class AdminService extends Service
{
    public function __construct(
        private ProductsRepo $productsRepo
    ) {}

    public function validateAdmin($token): array
    {
        $result = $this->validateToken($token);
        if ($result["successful"] && $result["admin_access"] === true) {
            return $result;
        } else {
            return [
                "successful" => false
            ];
        }
    }

    public function addNewProduct(string $token, string $productName, float $productAmount, int $productQuantity, string $productCategory): array
    {
        $result = $this->validateAdmin($token);
        if (!$result["successful"]) {
            return $result;
        }

        $data = [
            "name" => $productName,
            "amount" => $productAmount,
            "category" => $productCategory,
            "quantity" => $productQuantity
        ];
        if ($this->productsRepo->create($data)) {
            return [
                "successful" => true
            ];
        } else {
            return [
                "successful" => false
            ];
        }
    }

    public function deleteProductById(string $token, int $productId): array
    {
        $result = $this->validateAdmin($token);
        if (!$result["successful"]) {
            return $result;
        }

        if ($this->productsRepo->deleteById($productId)) {
            return [
                "successful" => true
            ];
        } else {
            return [
                "successful" =>false
            ];
        }
    }

    public function updateProductById(string $token, array $data): array
    {
        $result = $this->validateAdmin($token);
        if (!$result["successful"]) {
            return $result;
        }

        $productId = $data["id"];
        unset($data["id"]);
        if ($this->productsRepo->updateById($productId, $data)) {
            return [
                "successful" => true
            ];
        } else {
            return [
                "successful" => false
            ];
        }
    }
}
