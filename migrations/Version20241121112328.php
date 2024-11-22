<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121112328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, lvl INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercenheros (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_available TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, etat VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', munitions INT NOT NULL, lvl INT NOT NULL, life_points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercenheros_competences (mercenheros_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_5B0D7F8F3CEA12E2 (mercenheros_id), INDEX IDX_5B0D7F8FA660B158 (competences_id), PRIMARY KEY(mercenheros_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, assigned_team_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', location VARCHAR(255) NOT NULL, INDEX IDX_34F1D47E23F46021 (assigned_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, leader_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4E0A61F73154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_mercenheros (team_id INT NOT NULL, mercenheros_id INT NOT NULL, INDEX IDX_9EDEDBA4296CD8AE (team_id), INDEX IDX_9EDEDBA43CEA12E2 (mercenheros_id), PRIMARY KEY(team_id, mercenheros_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mercenheros_competences ADD CONSTRAINT FK_5B0D7F8F3CEA12E2 FOREIGN KEY (mercenheros_id) REFERENCES mercenheros (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mercenheros_competences ADD CONSTRAINT FK_5B0D7F8FA660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E23F46021 FOREIGN KEY (assigned_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F73154ED4 FOREIGN KEY (leader_id) REFERENCES mercenheros (id)');
        $this->addSql('ALTER TABLE team_mercenheros ADD CONSTRAINT FK_9EDEDBA4296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_mercenheros ADD CONSTRAINT FK_9EDEDBA43CEA12E2 FOREIGN KEY (mercenheros_id) REFERENCES mercenheros (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mercenheros_competences DROP FOREIGN KEY FK_5B0D7F8F3CEA12E2');
        $this->addSql('ALTER TABLE mercenheros_competences DROP FOREIGN KEY FK_5B0D7F8FA660B158');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E23F46021');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F73154ED4');
        $this->addSql('ALTER TABLE team_mercenheros DROP FOREIGN KEY FK_9EDEDBA4296CD8AE');
        $this->addSql('ALTER TABLE team_mercenheros DROP FOREIGN KEY FK_9EDEDBA43CEA12E2');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE mercenheros');
        $this->addSql('DROP TABLE mercenheros_competences');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_mercenheros');
    }
}
