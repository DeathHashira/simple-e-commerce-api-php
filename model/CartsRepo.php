<?php

namespace Model;

use PDO;

class CartsRepo extends BaseRepository
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
        $this->tableName = "carts";
    }

    public function deleteProduct(int $userId, int $productId): bool
    {
        $statement = $this->conn->prepare("DELETE FROM $this->tableName WHERE user_id=:user_id AND product_id=:product_id");
        $this->bindValues($statement, [
           ":user_id" => $userId,
           ":product_id" => $productId
        ]);

        return $statement->execute();
    }

    public function showAllItems(int $userId): array
    {
        $statement = $this->conn->prepare("SELECT products.id, products.name, products.amount, products.category
                                            FROM products JOIN users ON products.id=carts.product_id WHERE carts.user_id=:user_id");
        $statement->bindValue(":user_id", $userId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
