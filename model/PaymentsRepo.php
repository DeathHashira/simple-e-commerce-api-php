<?php

namespace Model;

use PDO;

class PymentsRepo extends BaseRepository
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
        $this->tableName = "payments";
    }
}
