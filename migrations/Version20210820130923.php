<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820130923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, user_id, title, url, message, created_at FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE BINARY, url VARCHAR(255) DEFAULT NULL COLLATE BINARY, message VARCHAR(255) DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, user_id, title, url, message, created_at) SELECT id, user_id, title, url, message, created_at FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('DROP INDEX IDX_2091C9AD4B89032C');
        $this->addSql('DROP INDEX IDX_2091C9ADA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_vote AS SELECT id, user_id, post_id, value FROM user_vote');
        $this->addSql('DROP TABLE user_vote');
        $this->addSql('CREATE TABLE user_vote (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER NOT NULL, value INTEGER NOT NULL, CONSTRAINT FK_2091C9ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2091C9AD4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_vote (id, user_id, post_id, value) SELECT id, user_id, post_id, value FROM __temp__user_vote');
        $this->addSql('DROP TABLE __temp__user_vote');
        $this->addSql('CREATE INDEX IDX_2091C9AD4B89032C ON user_vote (post_id)');
        $this->addSql('CREATE INDEX IDX_2091C9ADA76ED395 ON user_vote (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, user_id, title, url, message, created_at FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL, url VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO post (id, user_id, title, url, message, created_at) SELECT id, user_id, title, url, message, created_at FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('DROP INDEX IDX_2091C9ADA76ED395');
        $this->addSql('DROP INDEX IDX_2091C9AD4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_vote AS SELECT id, user_id, post_id, value FROM user_vote');
        $this->addSql('DROP TABLE user_vote');
        $this->addSql('CREATE TABLE user_vote (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER NOT NULL, value INTEGER NOT NULL)');
        $this->addSql('INSERT INTO user_vote (id, user_id, post_id, value) SELECT id, user_id, post_id, value FROM __temp__user_vote');
        $this->addSql('DROP TABLE __temp__user_vote');
        $this->addSql('CREATE INDEX IDX_2091C9ADA76ED395 ON user_vote (user_id)');
        $this->addSql('CREATE INDEX IDX_2091C9AD4B89032C ON user_vote (post_id)');
    }
}
