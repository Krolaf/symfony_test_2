<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120092100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, coordonnees_orbitales DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bestiary (id INT AUTO_INCREMENT NOT NULL, adress_id INT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_946DE9FF8486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spatioport (id INT AUTO_INCREMENT NOT NULL, adress_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FE045FBB8486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bestiary ADD CONSTRAINT FK_946DE9FF8486F9AC FOREIGN KEY (adress_id) REFERENCES spatioport (id)');
        $this->addSql('ALTER TABLE spatioport ADD CONSTRAINT FK_FE045FBB8486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bestiary DROP FOREIGN KEY FK_946DE9FF8486F9AC');
        $this->addSql('ALTER TABLE spatioport DROP FOREIGN KEY FK_FE045FBB8486F9AC');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE bestiary');
        $this->addSql('DROP TABLE spatioport');
    }
}
