<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260220183957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP created_at, DROP updated_at, DROP active');
        $this->addSql('ALTER TABLE ticket_category DROP created_at, DROP updated_at, DROP active');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD active TINYINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD active TINYINT NOT NULL');
        $this->addSql('ALTER TABLE ticket_category ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD active TINYINT NOT NULL');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at, DROP active');
    }
}
