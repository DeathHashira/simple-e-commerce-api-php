<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260927154103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create payments table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        total DECIMAL(10, 2),
        status VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE IF EXISTS payments");
    }
}
