<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120111515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bestiary_spatioport (bestiary_id INT NOT NULL, spatioport_id INT NOT NULL, INDEX IDX_E81C646A6466A409 (bestiary_id), INDEX IDX_E81C646A5076CB2C (spatioport_id), PRIMARY KEY(bestiary_id, spatioport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spatioport (id INT AUTO_INCREMENT NOT NULL, adress_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5C7DFDFB8486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bestiary_spatioport ADD CONSTRAINT FK_E81C646A6466A409 FOREIGN KEY (bestiary_id) REFERENCES bestiary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bestiary_spatioport ADD CONSTRAINT FK_E81C646A5076CB2C FOREIGN KEY (spatioport_id) REFERENCES spatioport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spatioport ADD CONSTRAINT FK_5C7DFDFB8486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE bestiary_spatioport DROP FOREIGN KEY FK_4A65C62A6466A409');
        $this->addSql('ALTER TABLE bestiary_spatioport DROP FOREIGN KEY FK_4A65C62A950451BD');
        $this->addSql('ALTER TABLE spatioport DROP FOREIGN KEY FK_FE045FBB8486F9AC');
        $this->addSql('DROP TABLE bestiary_spatioport');
        $this->addSql('DROP TABLE spatioport');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bestiary_spatioport (bestiary_id INT NOT NULL, spatioport_id INT NOT NULL, INDEX IDX_4A65C62A6466A409 (bestiary_id), INDEX IDX_4A65C62A950451BD (spatioport_id), PRIMARY KEY(bestiary_id, spatioport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE spatioport (id INT AUTO_INCREMENT NOT NULL, adress_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_FE045FBB8486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bestiary_spatioport ADD CONSTRAINT FK_4A65C62A6466A409 FOREIGN KEY (bestiary_id) REFERENCES bestiary (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bestiary_spatioport ADD CONSTRAINT FK_4A65C62A950451BD FOREIGN KEY (spatioport_id) REFERENCES spatioport (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spatioport ADD CONSTRAINT FK_FE045FBB8486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE bestiary_spatioport DROP FOREIGN KEY FK_E81C646A6466A409');
        $this->addSql('ALTER TABLE bestiary_spatioport DROP FOREIGN KEY FK_E81C646A5076CB2C');
        $this->addSql('ALTER TABLE spatioport DROP FOREIGN KEY FK_5C7DFDFB8486F9AC');
        $this->addSql('DROP TABLE bestiary_spatioport');
        $this->addSql('DROP TABLE spatioport');
    }
}
