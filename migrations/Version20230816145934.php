<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816145934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT NOT NULL, chambre_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_reversed TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, statut VARCHAR(255) NOT NULL, price INT DEFAULT NULL, guests INT DEFAULT NULL, children INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6EA9A1469B177F54 ON calendar (chambre_id)');
        $this->addSql('CREATE TABLE chambre (id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C509E4FF3DA5256D ON chambre (image_id)');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN image.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1469B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE calendar DROP CONSTRAINT FK_6EA9A1469B177F54');
        $this->addSql('ALTER TABLE chambre DROP CONSTRAINT FK_C509E4FF3DA5256D');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE image');
    }
}
