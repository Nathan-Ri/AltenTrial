<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201150808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, roles, name, email, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB DEFAULT NULL --(DC2Type:json)
        , name VARCHAR(25) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, roles, name, email, password) SELECT id, roles, name, email, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, roles, name, email, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , name VARCHAR(25) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, roles, name, email, password) SELECT id, roles, name, email, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
