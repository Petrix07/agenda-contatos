<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503004204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contato_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contato (id INT NOT NULL, pessoa_id INT NOT NULL, tipo BYTEA NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C384AB42DF6FA0A5 ON contato (pessoa_id)');
        $this->addSql('ALTER TABLE contato ADD CONSTRAINT FK_C384AB42DF6FA0A5 FOREIGN KEY (pessoa_id) REFERENCES pessoa (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contato_id_seq CASCADE');
        $this->addSql('ALTER TABLE contato DROP CONSTRAINT FK_C384AB42DF6FA0A5');
        $this->addSql('DROP TABLE contato');
    }
}
