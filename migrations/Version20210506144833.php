<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506144833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request ADD admin_user_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A6352511C FOREIGN KEY (admin_user_id) REFERENCES super_admin (id)');
        $this->addSql('CREATE INDEX IDX_7CE748A6352511C ON reset_password_request (admin_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748A6352511C');
        $this->addSql('DROP INDEX IDX_7CE748A6352511C ON reset_password_request');
        $this->addSql('ALTER TABLE reset_password_request DROP admin_user_id, CHANGE user_id user_id INT NOT NULL');
    }
}
