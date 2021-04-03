<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403183637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue ADD categorie_fourmi VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE horaire_lieu ADD raison_fermeture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu DROP raison_fermeture');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue DROP categorie_fourmi');
        $this->addSql('ALTER TABLE horaire_lieu DROP raison_fermeture');
        $this->addSql('ALTER TABLE lieu ADD raison_fermeture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
