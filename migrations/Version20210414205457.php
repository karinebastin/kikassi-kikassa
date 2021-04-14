<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414205457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire_lieu CHANGE ouv_am ouv_am VARCHAR(255) DEFAULT NULL, CHANGE ferme_am ferme_am VARCHAR(255) DEFAULT NULL, CHANGE ouv_pm ouv_pm VARCHAR(255) DEFAULT NULL, CHANGE ferme_pm ferme_pm VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire_lieu CHANGE ouv_am ouv_am TIME DEFAULT NULL, CHANGE ferme_am ferme_am TIME DEFAULT NULL, CHANGE ouv_pm ouv_pm TIME DEFAULT NULL, CHANGE ferme_pm ferme_pm TIME DEFAULT NULL');
    }
}
