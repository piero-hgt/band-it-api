<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201090736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init schema';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id UUID NOT NULL, venue_id UUID DEFAULT NULL, person_id UUID DEFAULT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, type VARCHAR(20) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C62E63840A73EBA ON contact (venue_id)');
        $this->addSql('CREATE INDEX IDX_4C62E638217BBB47 ON contact (person_id)');
        $this->addSql('COMMENT ON COLUMN contact.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact.venue_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact.person_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contact.created_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('COMMENT ON COLUMN contact.updated_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('CREATE TABLE person (id UUID NOT NULL, venue_id UUID DEFAULT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_34DCD17640A73EBA ON person (venue_id)');
        $this->addSql('COMMENT ON COLUMN person.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN person.venue_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN person.created_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('COMMENT ON COLUMN person.updated_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, role TEXT NOT NULL, enabled BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".role IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE venue (id UUID NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, avatar JSON DEFAULT NULL, description TEXT DEFAULT NULL, season VARCHAR(50) DEFAULT NULL, address_type VARCHAR(20) NOT NULL, address_line1 VARCHAR(255) NOT NULL, address_line2 VARCHAR(255) DEFAULT NULL, address_zipcode VARCHAR(20) NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(255) DEFAULT NULL, address_country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN venue.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN venue.created_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('COMMENT ON COLUMN venue.updated_at IS \'(DC2Type:carbon_immutable)\'');
        $this->addSql('COMMENT ON COLUMN venue.avatar IS \'(DC2Type:file)\'');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E63840A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17640A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E63840A73EBA');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638217BBB47');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT FK_34DCD17640A73EBA');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE venue');
    }
}
