<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202215225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_cart ADD COLUMN quantity INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_cart AS SELECT id, user_id, product_id FROM user_cart');
        $this->addSql('DROP TABLE user_cart');
        $this->addSql('CREATE TABLE user_cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, CONSTRAINT FK_7122C47EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7122C47E4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_cart (id, user_id, product_id) SELECT id, user_id, product_id FROM __temp__user_cart');
        $this->addSql('DROP TABLE __temp__user_cart');
        $this->addSql('CREATE INDEX IDX_7122C47EA76ED395 ON user_cart (user_id)');
        $this->addSql('CREATE INDEX IDX_7122C47E4584665A ON user_cart (product_id)');
    }
}
