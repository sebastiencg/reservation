<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230813151026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD chambre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1469B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6EA9A1469B177F54 ON calendar (chambre_id)');
        $this->addSql('ALTER TABLE chambre DROP CONSTRAINT fk_c509e4ffb83297e7');
        $this->addSql('DROP INDEX idx_c509e4ffb83297e7');
        $this->addSql('ALTER TABLE chambre DROP reservation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE calendar DROP CONSTRAINT FK_6EA9A1469B177F54');
        $this->addSql('DROP INDEX IDX_6EA9A1469B177F54');
        $this->addSql('ALTER TABLE calendar DROP chambre_id');
        $this->addSql('ALTER TABLE chambre ADD reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT fk_c509e4ffb83297e7 FOREIGN KEY (reservation_id) REFERENCES calendar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c509e4ffb83297e7 ON chambre (reservation_id)');
    }
}
