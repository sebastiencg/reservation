<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810142334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE chambre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chambre (id INT NOT NULL, reservation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, hote VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C509E4FFB83297E7 ON chambre (reservation_id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFB83297E7 FOREIGN KEY (reservation_id) REFERENCES calendar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chambre_id_seq CASCADE');
        $this->addSql('ALTER TABLE chambre DROP CONSTRAINT FK_C509E4FFB83297E7');
        $this->addSql('DROP TABLE chambre');
    }
}
