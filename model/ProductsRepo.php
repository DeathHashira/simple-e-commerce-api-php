<?php

namespace Model;

use PDO;

class ProductsRepo extends BaseRepository
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
        $this->tableName = "products";
    }
}
