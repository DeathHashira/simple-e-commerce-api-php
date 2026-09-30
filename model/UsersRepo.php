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

    public function adminAccess(int $id): bool
    {
        return $this->updateById($id, [
            "admin_access" => true
        ]);
    }
}
