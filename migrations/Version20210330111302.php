<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330111302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(6) NOT NULL, ville VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, categorie_fourmi VARCHAR(255) NOT NULL, montant_cotisation INT NOT NULL, moyen_paiement VARCHAR(255) NOT NULL, date_adhesion DATE NOT NULL, compte_actif TINYINT(1) NOT NULL, admin TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adhesion_bibliotheque (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, depot_permanent INT NOT NULL, fin_rc DATE DEFAULT NULL, justif_identite TINYINT(1) NOT NULL, justif_domicile TINYINT(1) NOT NULL, date_inscription DATE NOT NULL, satut_inscription VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2C59A66925F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, nom_catalogue VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, objet_id INT NOT NULL, adherent_id INT DEFAULT NULL, super_admin_id INT DEFAULT NULL, statut_emprunt_id INT NOT NULL, date_reservation DATE DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, remarque LONGTEXT DEFAULT NULL, date_retour_objet DATE DEFAULT NULL, depot_rajoute INT NOT NULL, penalites INT DEFAULT NULL, prix_emprunt INT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_364071D7F520CF5A (objet_id), INDEX IDX_364071D725F06C53 (adherent_id), INDEX IDX_364071D7BBF91D3B (super_admin_id), INDEX IDX_364071D7DBB4E29D (statut_emprunt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_lieu (id INT AUTO_INCREMENT NOT NULL, lieu_id INT NOT NULL, jour VARCHAR(255) NOT NULL, ouv_am TIME DEFAULT NULL, ferme_am TIME DEFAULT NULL, ouv_pm TIME DEFAULT NULL, ferme_pm TIME DEFAULT NULL, fermeture TINYINT(1) NOT NULL, INDEX IDX_773960016AB213CC (lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(6) NOT NULL, ville VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, adherent_id INT DEFAULT NULL, statut_objet_id INT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, lieu_id INT NOT NULL, denomination VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, valeur_achat INT NOT NULL, coef_usure INT NOT NULL, pourcent_calcul INT NOT NULL, vitrine TINYINT(1) NOT NULL, date_creation DATE NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_46CD4C3825F06C53 (adherent_id), INDEX IDX_46CD4C388A2673FB (statut_objet_id), INDEX IDX_46CD4C38BCF5E72D (categorie_id), INDEX IDX_46CD4C38365BF48 (sous_categorie_id), INDEX IDX_46CD4C386AB213CC (lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet_catalogue (objet_id INT NOT NULL, catalogue_id INT NOT NULL, INDEX IDX_91C01892F520CF5A (objet_id), INDEX IDX_91C018924A7843DC (catalogue_id), PRIMARY KEY(objet_id, catalogue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom_ss_categorie VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_52743D7BBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_emprunt (id INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_objet (id INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE super_admin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adhesion_bibliotheque ADD CONSTRAINT FK_2C59A66925F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D725F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7BBF91D3B FOREIGN KEY (super_admin_id) REFERENCES super_admin (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7DBB4E29D FOREIGN KEY (statut_emprunt_id) REFERENCES statut_emprunt (id)');
        $this->addSql('ALTER TABLE horaire_lieu ADD CONSTRAINT FK_773960016AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C3825F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C388A2673FB FOREIGN KEY (statut_objet_id) REFERENCES statut_objet (id)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C386AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE objet_catalogue ADD CONSTRAINT FK_91C01892F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objet_catalogue ADD CONSTRAINT FK_91C018924A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adhesion_bibliotheque DROP FOREIGN KEY FK_2C59A66925F06C53');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D725F06C53');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C3825F06C53');
        $this->addSql('ALTER TABLE objet_catalogue DROP FOREIGN KEY FK_91C018924A7843DC');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38BCF5E72D');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D');
        $this->addSql('ALTER TABLE horaire_lieu DROP FOREIGN KEY FK_773960016AB213CC');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C386AB213CC');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7F520CF5A');
        $this->addSql('ALTER TABLE objet_catalogue DROP FOREIGN KEY FK_91C01892F520CF5A');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38365BF48');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7DBB4E29D');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C388A2673FB');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7BBF91D3B');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE adhesion_bibliotheque');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE horaire_lieu');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE objet_catalogue');
        $this->addSql('DROP TABLE sous_categorie');
        $this->addSql('DROP TABLE statut_emprunt');
        $this->addSql('DROP TABLE statut_objet');
        $this->addSql('DROP TABLE super_admin');
    }
}
