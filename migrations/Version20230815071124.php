<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230815071124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create payouts table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE payouts (
            uuid VARCHAR(36) NOT NULL, 
            name VARCHAR(255) DEFAULT NULL, 
            email VARCHAR(255) NOT NULL,
            bank_account_number VARCHAR(255) NOT NULL,
            amount INT NOT NULL,
            status INT NOT NULL,
            created_at DATETIME NOT NULL, 
            PRIMARY KEY(uuid)
       ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE payouts');
    }
}
