<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517170230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alimentation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, couleur_id INT DEFAULT NULL, poil_id INT DEFAULT NULL, regime_id INT DEFAULT NULL, espece_id INT DEFAULT NULL, race_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, sexe TINYINT(1) NOT NULL, vermifugation TINYINT(1) DEFAULT NULL, vaccin TINYINT(1) DEFAULT NULL, puce_tatouage INT DEFAULT NULL, date_naissance DATE NOT NULL, UNIQUE INDEX UNIQ_6AAB231F8805AB2F (annonce_id), INDEX IDX_6AAB231FC31BA576 (couleur_id), INDEX IDX_6AAB231FF474F37F (poil_id), INDEX IDX_6AAB231F35E7D534 (regime_id), INDEX IDX_6AAB231F2D191E7A (espece_id), INDEX IDX_6AAB231F6E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_alimentation (animal_id INT NOT NULL, alimentation_id INT NOT NULL, INDEX IDX_3C7F6E5B8E962C16 (animal_id), INDEX IDX_3C7F6E5B8441D4D9 (alimentation_id), PRIMARY KEY(animal_id, alimentation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_publication DATE NOT NULL, date_modification DATE NOT NULL, INDEX IDX_F65593E5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couleur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espece (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, url VARCHAR(100) NOT NULL, INDEX IDX_C53D045F8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poil (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, espece_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, INDEX IDX_DA6FBBAF2D191E7A (espece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime_alimentation (regime_id INT NOT NULL, alimentation_id INT NOT NULL, INDEX IDX_F0A422335E7D534 (regime_id), INDEX IDX_F0A42238441D4D9 (alimentation_id), PRIMARY KEY(regime_id, alimentation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(100) DEFAULT NULL, telephone VARCHAR(30) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FC31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FF474F37F FOREIGN KEY (poil_id) REFERENCES poil (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F35E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal_alimentation ADD CONSTRAINT FK_3C7F6E5B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_alimentation ADD CONSTRAINT FK_3C7F6E5B8441D4D9 FOREIGN KEY (alimentation_id) REFERENCES alimentation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAF2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE regime_alimentation ADD CONSTRAINT FK_F0A422335E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE regime_alimentation ADD CONSTRAINT FK_F0A42238441D4D9 FOREIGN KEY (alimentation_id) REFERENCES alimentation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F8805AB2F');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FC31BA576');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FF474F37F');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F35E7D534');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F2D191E7A');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE animal_alimentation DROP FOREIGN KEY FK_3C7F6E5B8E962C16');
        $this->addSql('ALTER TABLE animal_alimentation DROP FOREIGN KEY FK_3C7F6E5B8441D4D9');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8805AB2F');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAF2D191E7A');
        $this->addSql('ALTER TABLE regime_alimentation DROP FOREIGN KEY FK_F0A422335E7D534');
        $this->addSql('ALTER TABLE regime_alimentation DROP FOREIGN KEY FK_F0A42238441D4D9');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE alimentation');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_alimentation');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE couleur');
        $this->addSql('DROP TABLE espece');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE poil');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE regime');
        $this->addSql('DROP TABLE regime_alimentation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
