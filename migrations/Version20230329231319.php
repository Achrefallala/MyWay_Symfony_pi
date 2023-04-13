<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329231319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moyentp ADD ligne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE moyentp ADD CONSTRAINT FK_2F8AE1BF5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id)');
        $this->addSql('CREATE INDEX IDX_2F8AE1BF5A438E76 ON moyentp (ligne_id)');
        $this->addSql('ALTER TABLE trajet ADD ligne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98C5A438E76 ON trajet (ligne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moyentp DROP FOREIGN KEY FK_2F8AE1BF5A438E76');
        $this->addSql('DROP INDEX IDX_2F8AE1BF5A438E76 ON moyentp');
        $this->addSql('ALTER TABLE moyentp DROP ligne_id');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C5A438E76');
        $this->addSql('DROP INDEX IDX_2B5BA98C5A438E76 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP ligne_id');
    }
}
