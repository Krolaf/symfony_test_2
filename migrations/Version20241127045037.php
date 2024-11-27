<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127045037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE missions_competences (missions_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_7B337A9A17C042CF (missions_id), INDEX IDX_7B337A9AA660B158 (competences_id), PRIMARY KEY(missions_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE missions_competences ADD CONSTRAINT FK_7B337A9A17C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_competences ADD CONSTRAINT FK_7B337A9AA660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE missions_competences DROP FOREIGN KEY FK_7B337A9A17C042CF');
        $this->addSql('ALTER TABLE missions_competences DROP FOREIGN KEY FK_7B337A9AA660B158');
        $this->addSql('DROP TABLE missions_competences');
    }
}
