<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260121162406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_ticket_qrtoken ON ticket');
        $this->addSql('ALTER TABLE ticket RENAME INDEX uniq_97a0ada388cfe0d TO uniq_ticket_qrtoken');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX idx_ticket_qrtoken ON ticket (qrtoken(768))');
        $this->addSql('ALTER TABLE ticket RENAME INDEX uniq_ticket_qrtoken TO UNIQ_97A0ADA388CFE0D');
    }
}
