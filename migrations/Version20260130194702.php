<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260130194702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX idx_event_status ON event (status)');
        $this->addSql('CREATE INDEX idx_event_start_at ON event (start_at)');
        $this->addSql('CREATE INDEX idx_event_end_at ON event (end_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_event_status ON event');
        $this->addSql('DROP INDEX idx_event_start_at ON event');
        $this->addSql('DROP INDEX idx_event_end_at ON event');
    }
}
