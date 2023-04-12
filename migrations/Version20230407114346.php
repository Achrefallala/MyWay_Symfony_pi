<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407114346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_transport (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, moyen_transport_id INT NOT NULL, UNIQUE INDEX UNIQ_A94E2EA6D12A823 (trajet_id), UNIQUE INDEX UNIQ_A94E2EA63ED8D53F (moyen_transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moyen_transport (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, organisation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, nbr_places INT NOT NULL, horaires VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_transport ADD CONSTRAINT FK_A94E2EA6D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE ligne_transport ADD CONSTRAINT FK_A94E2EA63ED8D53F FOREIGN KEY (moyen_transport_id) REFERENCES moyen_transport (id)');
        $this->addSql('ALTER TABLE etablissement ADD adresse VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_transport DROP FOREIGN KEY FK_A94E2EA6D12A823');
        $this->addSql('ALTER TABLE ligne_transport DROP FOREIGN KEY FK_A94E2EA63ED8D53F');
        $this->addSql('DROP TABLE ligne_transport');
        $this->addSql('DROP TABLE moyen_transport');
        $this->addSql('ALTER TABLE etablissement DROP adresse');
    }
}
