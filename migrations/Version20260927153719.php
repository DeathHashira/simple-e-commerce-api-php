<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260927153719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create carts table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE carts (
        user_id INT,
        product_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(id)
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE IF EXISTS carts");
    }
}
