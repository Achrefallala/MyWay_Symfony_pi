<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326014640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_ligne (ligne_id INT NOT NULL, trajet_id INT NOT NULL, INDEX IDX_E1993FF95A438E76 (ligne_id), INDEX IDX_E1993FF9D12A823 (trajet_id), PRIMARY KEY(ligne_id, trajet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moyentp_ligne (ligne_id INT NOT NULL, moyentp_id INT NOT NULL, INDEX IDX_92152F525A438E76 (ligne_id), INDEX IDX_92152F52E24BD4A1 (moyentp_id), PRIMARY KEY(ligne_id, moyentp_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moyentp (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, nbreplace INT NOT NULL, prix_ticket INT NOT NULL, horaire VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, depart VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, etat VARCHAR(255) DEFAULT NULL, directions VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajet_ligne ADD CONSTRAINT FK_E1993FF95A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_ligne ADD CONSTRAINT FK_E1993FF9D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE moyentp_ligne ADD CONSTRAINT FK_92152F525A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE moyentp_ligne ADD CONSTRAINT FK_92152F52E24BD4A1 FOREIGN KEY (moyentp_id) REFERENCES moyentp (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajet_ligne DROP FOREIGN KEY FK_E1993FF95A438E76');
        $this->addSql('ALTER TABLE trajet_ligne DROP FOREIGN KEY FK_E1993FF9D12A823');
        $this->addSql('ALTER TABLE moyentp_ligne DROP FOREIGN KEY FK_92152F525A438E76');
        $this->addSql('ALTER TABLE moyentp_ligne DROP FOREIGN KEY FK_92152F52E24BD4A1');
        $this->addSql('DROP TABLE ligne');
        $this->addSql('DROP TABLE trajet_ligne');
        $this->addSql('DROP TABLE moyentp_ligne');
        $this->addSql('DROP TABLE moyentp');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
