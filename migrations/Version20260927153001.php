<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260927153001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) UNIQUE,
        username VARCHAR(255),
        password VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE IF EXISTS users");
    }
}
