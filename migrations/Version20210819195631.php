<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819195631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD COLUMN created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, url, message, votes FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL, url VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, votes INTEGER DEFAULT 0 NOT NULL)');
        $this->addSql('INSERT INTO post (id, title, url, message, votes) SELECT id, title, url, message, votes FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}
