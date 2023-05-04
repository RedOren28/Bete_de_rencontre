<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504184938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_alimentation DROP FOREIGN KEY FK_3C7F6E5B8441D4D9');
        $this->addSql('ALTER TABLE animal_alimentation DROP FOREIGN KEY FK_3C7F6E5B8E962C16');
        $this->addSql('DROP TABLE alimentation');
        $this->addSql('DROP TABLE animal_alimentation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alimentation (id INT AUTO_INCREMENT NOT NULL, regime VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nourriture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE animal_alimentation (animal_id INT NOT NULL, alimentation_id INT NOT NULL, INDEX IDX_3C7F6E5B8441D4D9 (alimentation_id), INDEX IDX_3C7F6E5B8E962C16 (animal_id), PRIMARY KEY(animal_id, alimentation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal_alimentation ADD CONSTRAINT FK_3C7F6E5B8441D4D9 FOREIGN KEY (alimentation_id) REFERENCES alimentation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_alimentation ADD CONSTRAINT FK_3C7F6E5B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
