<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702142422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mesto_mestonomers (id UUID NOT NULL, raion_id VARCHAR(255) NOT NULL, nomer VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN mesto_mestonomers.id IS \'(DC2Type:mesto_mestonomer_id)\'');
        $this->addSql('CREATE TABLE mesto_okrug_oblast_raions (id UUID NOT NULL, oblast_id UUID NOT NULL, name VARCHAR(255) NOT NULL, nomer VARCHAR(255) NOT NULL, mesto VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A54E56BB8CB685 ON mesto_okrug_oblast_raions (oblast_id)');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblast_raions.id IS \'(DC2Type:mesto_okrug_oblast_raion_id)\'');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblast_raions.oblast_id IS \'(DC2Type:mesto_okrug_oblast_id)\'');
        $this->addSql('CREATE TABLE mesto_okrug_oblasts (id UUID NOT NULL, okrug_id UUID NOT NULL, name VARCHAR(255) NOT NULL, nomer VARCHAR(255) NOT NULL, mesto VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FD54429AD71658C ON mesto_okrug_oblasts (okrug_id)');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblasts.id IS \'(DC2Type:mesto_okrug_oblast_id)\'');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblasts.okrug_id IS \'(DC2Type:mesto_okrug_id)\'');
        $this->addSql('CREATE TABLE mesto_okrugs (id UUID NOT NULL, name VARCHAR(255) NOT NULL, nomer VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN mesto_okrugs.id IS \'(DC2Type:mesto_okrug_id)\'');
        $this->addSql('ALTER TABLE mesto_okrug_oblast_raions ADD CONSTRAINT FK_6A54E56BB8CB685 FOREIGN KEY (oblast_id) REFERENCES mesto_okrug_oblasts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mesto_okrug_oblasts ADD CONSTRAINT FK_9FD54429AD71658C FOREIGN KEY (okrug_id) REFERENCES mesto_okrugs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mesto_okrug_oblast_raions DROP CONSTRAINT FK_6A54E56BB8CB685');
        $this->addSql('ALTER TABLE mesto_okrug_oblasts DROP CONSTRAINT FK_9FD54429AD71658C');
        $this->addSql('DROP TABLE mesto_mestonomers');
        $this->addSql('DROP TABLE mesto_okrug_oblast_raions');
        $this->addSql('DROP TABLE mesto_okrug_oblasts');
        $this->addSql('DROP TABLE mesto_okrugs');
    }
}
