<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717131442 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_pchel_kategorias (id UUID NOT NULL, name VARCHAR(255) NOT NULL, permissions JSON NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A482B365E237E06 ON admin_pchel_kategorias (name)');
        $this->addSql('COMMENT ON COLUMN admin_pchel_kategorias.id IS \'(DC2Type:admin_pchel_kategoria_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchel_kategorias.permissions IS \'(DC2Type:admin_pchel_kategoria_permissions)\'');
        $this->addSql('CREATE TABLE admin_pchelomat_pchelosezons (id UUID NOT NULL, pchelomatka_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1AD7E56ACDD581E1 ON admin_pchelomat_pchelosezons (pchelomatka_id)');
        $this->addSql('COMMENT ON COLUMN admin_pchelomat_pchelosezons.id IS \'(DC2Type:admin_pchelomat_pchelosezon_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomat_pchelosezons.pchelomatka_id IS \'(DC2Type:admin_pchelomat_id)\'');
        $this->addSql('CREATE TABLE admin_pchelomat_pchelovods (id UUID NOT NULL, pchelomatka_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C3972DFFCDD581E1 ON admin_pchelomat_pchelovods (pchelomatka_id)');
        $this->addSql('CREATE INDEX IDX_C3972DFF6931F8F9 ON admin_pchelomat_pchelovods (uchastie_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C3972DFFCDD581E16931F8F9 ON admin_pchelomat_pchelovods (pchelomatka_id, uchastie_id)');
        $this->addSql('COMMENT ON COLUMN admin_pchelomat_pchelovods.pchelomatka_id IS \'(DC2Type:admin_pchelomat_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomat_pchelovods.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('CREATE TABLE admin_pchelomat_pchelovod_pchelosezons (pchelovod_id UUID NOT NULL, pchelosezon_id UUID NOT NULL, PRIMARY KEY(pchelovod_id, pchelosezon_id))');
        $this->addSql('CREATE INDEX IDX_E1207E8B538ACC03 ON admin_pchelomat_pchelovod_pchelosezons (pchelovod_id)');
        $this->addSql('CREATE INDEX IDX_E1207E8BC742510D ON admin_pchelomat_pchelovod_pchelosezons (pchelosezon_id)');
        $this->addSql('COMMENT ON COLUMN admin_pchelomat_pchelovod_pchelosezons.pchelosezon_id IS \'(DC2Type:admin_pchelomat_pchelosezon_id)\'');
        $this->addSql('CREATE TABLE admin_pchelomats (id UUID NOT NULL, mesto_id UUID NOT NULL, persona_id UUID NOT NULL, kategoria_id UUID NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort INT NOT NULL, status VARCHAR(16) NOT NULL, goda_vixod INT NOT NULL, date_vixod TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C113468CE3CB56 ON admin_pchelomats (mesto_id)');
        $this->addSql('CREATE INDEX IDX_4C11346F5F88DB9 ON admin_pchelomats (persona_id)');
        $this->addSql('CREATE INDEX IDX_4C11346359B0684 ON admin_pchelomats (kategoria_id)');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.id IS \'(DC2Type:admin_pchelomat_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.mesto_id IS \'(DC2Type:mesto_mestonomer_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.persona_id IS \'(DC2Type:adminka_uchasties_persona_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.kategoria_id IS \'(DC2Type:admin_pchel_kategoria_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.status IS \'(DC2Type:admin_pchelomat_status)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.date_vixod IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_pchelomats.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelosezons ADD CONSTRAINT FK_1AD7E56ACDD581E1 FOREIGN KEY (pchelomatka_id) REFERENCES admin_pchelomats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovods ADD CONSTRAINT FK_C3972DFFCDD581E1 FOREIGN KEY (pchelomatka_id) REFERENCES admin_pchelomats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovods ADD CONSTRAINT FK_C3972DFF6931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovod_pchelosezons ADD CONSTRAINT FK_E1207E8B538ACC03 FOREIGN KEY (pchelovod_id) REFERENCES admin_pchelomat_pchelovods (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovod_pchelosezons ADD CONSTRAINT FK_E1207E8BC742510D FOREIGN KEY (pchelosezon_id) REFERENCES admin_pchelomat_pchelosezons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomats ADD CONSTRAINT FK_4C113468CE3CB56 FOREIGN KEY (mesto_id) REFERENCES mesto_mestonomers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomats ADD CONSTRAINT FK_4C11346F5F88DB9 FOREIGN KEY (persona_id) REFERENCES adminka_uchasties_personas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_pchelomats ADD CONSTRAINT FK_4C11346359B0684 FOREIGN KEY (kategoria_id) REFERENCES admin_pchel_kategorias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_pchelomats DROP CONSTRAINT FK_4C11346359B0684');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovod_pchelosezons DROP CONSTRAINT FK_E1207E8BC742510D');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovod_pchelosezons DROP CONSTRAINT FK_E1207E8B538ACC03');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelosezons DROP CONSTRAINT FK_1AD7E56ACDD581E1');
        $this->addSql('ALTER TABLE admin_pchelomat_pchelovods DROP CONSTRAINT FK_C3972DFFCDD581E1');
        $this->addSql('DROP TABLE admin_pchel_kategorias');
        $this->addSql('DROP TABLE admin_pchelomat_pchelosezons');
        $this->addSql('DROP TABLE admin_pchelomat_pchelovods');
        $this->addSql('DROP TABLE admin_pchelomat_pchelovod_pchelosezons');
        $this->addSql('DROP TABLE admin_pchelomats');
    }
}
