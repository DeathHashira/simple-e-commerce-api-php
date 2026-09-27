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
}
