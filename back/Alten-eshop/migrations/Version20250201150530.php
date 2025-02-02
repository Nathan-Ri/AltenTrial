<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201150530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, value VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6A2DD681D775834 ON access_token (value)');
        $this->addSql('CREATE INDEX IDX_B6A2DD68A76ED395 ON access_token (user_id)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, quantity INTEGER NOT NULL, internal_reference VARCHAR(255) NOT NULL, shell_id INTEGER DEFAULT NULL, inventory_status VARCHAR(255) NOT NULL, rating INTEGER DEFAULT NULL, created_at INTEGER NOT NULL, updated_at INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , name VARCHAR(25) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user_product (user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(user_id, product_id), CONSTRAINT FK_8B471AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8B471AA74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8B471AA7A76ED395 ON user_product (user_id)');
        $this->addSql('CREATE INDEX IDX_8B471AA74584665A ON user_product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_product');
    }
}
