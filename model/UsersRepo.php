<?php

namespace Model;

use PDO;

class UsersRepo extends BaseRepository
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
        $this->tableName = "users";
    }
}
