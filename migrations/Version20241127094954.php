<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127094954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE missions_teams (missions_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_4C1F476217C042CF (missions_id), INDEX IDX_4C1F4762296CD8AE (team_id), PRIMARY KEY(missions_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE missions_teams ADD CONSTRAINT FK_4C1F476217C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_teams ADD CONSTRAINT FK_4C1F4762296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E23F46021');
        $this->addSql('DROP INDEX IDX_34F1D47E23F46021 ON missions');
        $this->addSql('ALTER TABLE missions DROP assigned_team_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE missions_teams DROP FOREIGN KEY FK_4C1F476217C042CF');
        $this->addSql('ALTER TABLE missions_teams DROP FOREIGN KEY FK_4C1F4762296CD8AE');
        $this->addSql('DROP TABLE missions_teams');
        $this->addSql('ALTER TABLE missions ADD assigned_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E23F46021 FOREIGN KEY (assigned_team_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_34F1D47E23F46021 ON missions (assigned_team_id)');
    }
}
