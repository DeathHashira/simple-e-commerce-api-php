<?php

namespace Model;

use PDO;
use PDOStatement;

class BaseRepository
{
    protected string $tableName = '';
    
    public function __construct(
        private PDO $conn
    ) {}

    public function readById(int $id): array
    {
        $statement = $this->conn->prepare("SELECT * FROM $this->tableName WHERE id=:id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll(): array
    {
        $statement = $this->conn->prepare("SELECT * FROM $this->tableName");
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $keys = implode(", ", array_keys($data));
        $values = implode(", ", array_map(function($key) {return ":$key";}, array_keys($data)));
        
        $statement = $this->conn->prepare("INSERT INTO TABLE $this->tableName ($keys) VALUES ($values)");
        $this->bindValues($statement, $data);

        return $statement->execute();
    }

    public function deleteById(int $id): bool
    {
        $statement = $this->conn->prepare("DELETE FROM $this->tableName WHERE id=:id");
        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    public function updateById(int $id, array $data): bool
    {
        $set = $this->formatSet($data);
        $statement = $this->conn->prepare("UPDATE $this->tableName SET $set WHERE id=:id");
        $this->bindValues($statement, $data);
        $statement->bindValue(":id", $id);

        return $statement->execute();
    }

    private function bindValues(PDOStatement $stmnt, array $data)
    {
        foreach ($data as $key => $value) {
            $stmnt->bindValue(":".$key, $value);
        }
    }

    private function formatSet(array $data): string
    {
        return implode(", ", array_map(function($key) {return "$key=:$key";}, array_keys($data)));
    }
}