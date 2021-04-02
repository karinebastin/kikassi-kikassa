<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402135433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7DBB4E29D');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C388A2673FB');
        $this->addSql('DROP TABLE statut_emprunt');
        $this->addSql('DROP TABLE statut_objet');
        $this->addSql('DROP INDEX IDX_364071D7DBB4E29D ON emprunt');
        $this->addSql('ALTER TABLE emprunt ADD statut VARCHAR(255) NOT NULL, DROP statut_emprunt_id');
        $this->addSql('DROP INDEX IDX_46CD4C388A2673FB ON objet');
        $this->addSql('ALTER TABLE objet ADD statut VARCHAR(255) NOT NULL, DROP statut_objet_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut_emprunt (id INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE statut_objet (id INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE emprunt ADD statut_emprunt_id INT NOT NULL, DROP statut');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7DBB4E29D FOREIGN KEY (statut_emprunt_id) REFERENCES statut_emprunt (id)');
        $this->addSql('CREATE INDEX IDX_364071D7DBB4E29D ON emprunt (statut_emprunt_id)');
        $this->addSql('ALTER TABLE objet ADD statut_objet_id INT NOT NULL, DROP statut');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C388A2673FB FOREIGN KEY (statut_objet_id) REFERENCES statut_objet (id)');
        $this->addSql('CREATE INDEX IDX_46CD4C388A2673FB ON objet (statut_objet_id)');
    }
}
