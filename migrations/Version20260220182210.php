<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260220182210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, active TINYINT NOT NULL, id INT AUTO_INCREMENT NOT NULL, total DOUBLE PRECISION NOT NULL, status VARCHAR(40) NOT NULL, service_fee DOUBLE PRECISION DEFAULT NULL, subtotal DOUBLE PRECISION DEFAULT NULL, buyer_id INT NOT NULL, INDEX IDX_E00CEDDE6C755722 (buyer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE buyer (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE event (created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, active TINYINT NOT NULL, id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(2000) NOT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, capacity INT DEFAULT NULL, status VARCHAR(80) DEFAULT NULL, img_path VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, organizer_id INT NOT NULL, INDEX IDX_3BAE0AA7876C4DDA (organizer_id), INDEX idx_event_status (status), INDEX idx_event_start_at (start_at), INDEX idx_event_end_at (end_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE organizer (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, mobile VARCHAR(20) DEFAULT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ticket (created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, active TINYINT NOT NULL, id INT AUTO_INCREMENT NOT NULL, status VARCHAR(80) NOT NULL, checked_in_at DATETIME DEFAULT NULL, qrtoken VARCHAR(1000) NOT NULL, category_id INT DEFAULT NULL, booking_id INT DEFAULT NULL, INDEX IDX_97A0ADA312469DE2 (category_id), INDEX IDX_97A0ADA33301C60 (booking_id), INDEX idx_ticket_status (status), INDEX idx_ticket_checked_in_at (checked_in_at), UNIQUE INDEX uniq_ticket_qrtoken (qrtoken), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ticket_category (created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, active TINYINT NOT NULL, id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, quantity INT NOT NULL, event_id INT NOT NULL, INDEX IDX_8325E54071F7E88B (event_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT NOT NULL, buyer_id INT NOT NULL, organizer_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6496C755722 (buyer_id), UNIQUE INDEX UNIQ_8D93D649876C4DDA (organizer_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE6C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA312469DE2 FOREIGN KEY (category_id) REFERENCES ticket_category (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA33301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE ticket_category ADD CONSTRAINT FK_8325E54071F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE6C755722');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7876C4DDA');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA312469DE2');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA33301C60');
        $this->addSql('ALTER TABLE ticket_category DROP FOREIGN KEY FK_8325E54071F7E88B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496C755722');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649876C4DDA');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE buyer');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE organizer');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
