<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225151626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy (id INT AUTO_INCREMENT NOT NULL, id_candidate_id INT NOT NULL, id_job_offer_id INT NOT NULL, is_valid TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D930569DB27CF2F3 (id_candidate_id), UNIQUE INDEX UNIQ_D930569D1740A4E7 (id_job_offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569DB27CF2F3 FOREIGN KEY (id_candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D1740A4E7 FOREIGN KEY (id_job_offer_id) REFERENCES job_offer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569DB27CF2F3');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D1740A4E7');
        $this->addSql('DROP TABLE candidacy');
    }
}
