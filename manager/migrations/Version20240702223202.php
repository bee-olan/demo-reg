<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702223202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_uchasties_groups (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN admin_uchasties_groups.id IS \'(DC2Type:admin_uchasties_group_id)\'');
        $this->addSql('CREATE TABLE admin_uchasties_uchasties (id UUID NOT NULL, group_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, nike VARCHAR(255) NOT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_777EAE38FE54D947 ON admin_uchasties_uchasties (group_id)');
        $this->addSql('COMMENT ON COLUMN admin_uchasties_uchasties.id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_uchasties_uchasties.group_id IS \'(DC2Type:admin_uchasties_group_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_uchasties_uchasties.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_uchasties_uchasties.email IS \'(DC2Type:admin_uchasties_uchastie_email)\'');
        $this->addSql('COMMENT ON COLUMN admin_uchasties_uchasties.status IS \'(DC2Type:admin_uchasties_uchastie_status)\'');
        $this->addSql('CREATE TABLE adminka_uchasties_personas (id UUID NOT NULL, nomer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN adminka_uchasties_personas.id IS \'(DC2Type:adminka_uchasties_persona_id)\'');
        $this->addSql('ALTER TABLE admin_uchasties_uchasties ADD CONSTRAINT FK_777EAE38FE54D947 FOREIGN KEY (group_id) REFERENCES admin_uchasties_groups (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_uchasties_uchasties DROP CONSTRAINT FK_777EAE38FE54D947');
        $this->addSql('DROP TABLE admin_uchasties_groups');
        $this->addSql('DROP TABLE admin_uchasties_uchasties');
        $this->addSql('DROP TABLE adminka_uchasties_personas');
    }
}
