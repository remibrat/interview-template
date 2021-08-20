<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819195408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD COLUMN title VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE post ADD COLUMN url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD COLUMN message VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD COLUMN votes INTEGER NOT NULL');
        $this->addSql('ALTER TABLE post ADD COLUMN created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO post (id) SELECT id FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}
