<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251222124001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY `FK_3BAE0AA77ED69B9D`');
        $this->addSql('DROP INDEX IDX_3BAE0AA77ED69B9D ON event');
        $this->addSql('ALTER TABLE event DROP ticket_category_id, CHANGE status status VARCHAR(80) DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD buyer_id INT NOT NULL, ADD category_id INT DEFAULT NULL, CHANGE qrcode qrcode VARCHAR(5000) DEFAULT NULL, CHANGE status status VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA312469DE2 FOREIGN KEY (category_id) REFERENCES ticket_category (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA36C755722 ON ticket (buyer_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA312469DE2 ON ticket (category_id)');
        $this->addSql('ALTER TABLE ticket_category DROP FOREIGN KEY `FK_8325E540700047D2`');
        $this->addSql('DROP INDEX IDX_8325E540700047D2 ON ticket_category');
        $this->addSql('ALTER TABLE ticket_category ADD event_id INT NOT NULL, DROP ticket_id');
        $this->addSql('ALTER TABLE ticket_category ADD CONSTRAINT FK_8325E54071F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_8325E54071F7E88B ON ticket_category (event_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY `FK_8D93D649700047D2`');
        $this->addSql('DROP INDEX IDX_8D93D649700047D2 ON user');
        $this->addSql('ALTER TABLE user DROP ticket_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD ticket_category_id INT DEFAULT NULL, CHANGE status status VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT `FK_3BAE0AA77ED69B9D` FOREIGN KEY (ticket_category_id) REFERENCES ticket_category (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77ED69B9D ON event (ticket_category_id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA36C755722');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA312469DE2');
        $this->addSql('DROP INDEX IDX_97A0ADA36C755722 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA312469DE2 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP buyer_id, DROP category_id, CHANGE qrcode qrcode VARCHAR(2000) DEFAULT NULL, CHANGE status status VARCHAR(80) DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket_category DROP FOREIGN KEY FK_8325E54071F7E88B');
        $this->addSql('DROP INDEX IDX_8325E54071F7E88B ON ticket_category');
        $this->addSql('ALTER TABLE ticket_category ADD ticket_id INT DEFAULT NULL, DROP event_id');
        $this->addSql('ALTER TABLE ticket_category ADD CONSTRAINT `FK_8325E540700047D2` FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_8325E540700047D2 ON ticket_category (ticket_id)');
        $this->addSql('ALTER TABLE user ADD ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT `FK_8D93D649700047D2` FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649700047D2 ON user (ticket_id)');
    }
}
