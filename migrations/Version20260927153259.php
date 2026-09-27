<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260927153259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create products table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        amount DECIMAL(10, 2),
        quantity INT,
        category VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE IF EXISTS products");
    }
}
