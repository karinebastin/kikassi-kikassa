<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405205128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE objet_catalogue');
        $this->addSql('ALTER TABLE objet ADD catalogue_id INT NOT NULL');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C384A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('CREATE INDEX IDX_46CD4C384A7843DC ON objet (catalogue_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE objet_catalogue (objet_id INT NOT NULL, catalogue_id INT NOT NULL, INDEX IDX_91C01892F520CF5A (objet_id), INDEX IDX_91C018924A7843DC (catalogue_id), PRIMARY KEY(objet_id, catalogue_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE objet_catalogue ADD CONSTRAINT FK_91C018924A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objet_catalogue ADD CONSTRAINT FK_91C01892F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C384A7843DC');
        $this->addSql('DROP INDEX IDX_46CD4C384A7843DC ON objet');
        $this->addSql('ALTER TABLE objet DROP catalogue_id');
    }
}
