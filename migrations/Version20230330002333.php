<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330002333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne ADD trajet_id INT DEFAULT NULL, ADD moyentp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne ADD CONSTRAINT FK_57F0DB83D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE ligne ADD CONSTRAINT FK_57F0DB83E24BD4A1 FOREIGN KEY (moyentp_id) REFERENCES moyentp (id)');
        $this->addSql('CREATE INDEX IDX_57F0DB83D12A823 ON ligne (trajet_id)');
        $this->addSql('CREATE INDEX IDX_57F0DB83E24BD4A1 ON ligne (moyentp_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne DROP FOREIGN KEY FK_57F0DB83D12A823');
        $this->addSql('ALTER TABLE ligne DROP FOREIGN KEY FK_57F0DB83E24BD4A1');
        $this->addSql('DROP INDEX IDX_57F0DB83D12A823 ON ligne');
        $this->addSql('DROP INDEX IDX_57F0DB83E24BD4A1 ON ligne');
        $this->addSql('ALTER TABLE ligne DROP trajet_id, DROP moyentp_id');
    }
}
