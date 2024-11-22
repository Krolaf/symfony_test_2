<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120110614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bestiary_spatioport (bestiary_id INT NOT NULL, spatioport_id INT NOT NULL, INDEX IDX_4A65C62A6466A409 (bestiary_id), INDEX IDX_4A65C62A950451BD (spatioport_id), PRIMARY KEY(bestiary_id, spatioport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bestiary_spatioport ADD CONSTRAINT FK_4A65C62A6466A409 FOREIGN KEY (bestiary_id) REFERENCES bestiary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bestiary_spatioport ADD CONSTRAINT FK_4A65C62A950451BD FOREIGN KEY (spatioport_id) REFERENCES spatioport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bestiary DROP FOREIGN KEY FK_946DE9FF8486F9AC');
        $this->addSql('DROP INDEX UNIQ_946DE9FF8486F9AC ON bestiary');
        $this->addSql('ALTER TABLE bestiary DROP adress_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bestiary_spatioport DROP FOREIGN KEY FK_4A65C62A6466A409');
        $this->addSql('ALTER TABLE bestiary_spatioport DROP FOREIGN KEY FK_4A65C62A950451BD');
        $this->addSql('DROP TABLE bestiary_spatioport');
        $this->addSql('ALTER TABLE bestiary ADD adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE bestiary ADD CONSTRAINT FK_946DE9FF8486F9AC FOREIGN KEY (adress_id) REFERENCES spatioport (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_946DE9FF8486F9AC ON bestiary (adress_id)');
    }
}
