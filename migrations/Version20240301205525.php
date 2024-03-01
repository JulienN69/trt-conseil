<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301205525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D1740A4E7');
        $this->addSql('CREATE TABLE announcement_candidate (announcement_id INT NOT NULL, candidate_id INT NOT NULL, INDEX IDX_EC7D6068913AEA17 (announcement_id), INDEX IDX_EC7D606891BD8781 (candidate_id), PRIMARY KEY(announcement_id, candidate_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement_candidate ADD CONSTRAINT FK_EC7D6068913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement_candidate ADD CONSTRAINT FK_EC7D606891BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement_candidacy DROP FOREIGN KEY FK_FDFFB8B1913AEA17');
        $this->addSql('ALTER TABLE announcement_candidacy DROP FOREIGN KEY FK_FDFFB8B159B22434');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E156BE243');
        $this->addSql('DROP TABLE announcement_candidacy');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569DB27CF2F3');
        $this->addSql('DROP INDEX UNIQ_D930569DB27CF2F3 ON candidacy');
        $this->addSql('DROP INDEX UNIQ_D930569D1740A4E7 ON candidacy');
        $this->addSql('ALTER TABLE candidacy DROP id_candidate_id, DROP id_job_offer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement_candidacy (announcement_id INT NOT NULL, candidacy_id INT NOT NULL, INDEX IDX_FDFFB8B1913AEA17 (announcement_id), INDEX IDX_FDFFB8B159B22434 (candidacy_id), PRIMARY KEY(announcement_id, candidacy_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT NOT NULL, job_title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, work_place VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, description LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, is_valid TINYINT(1) NOT NULL, INDEX IDX_288A3A4E156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE announcement_candidacy ADD CONSTRAINT FK_FDFFB8B1913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement_candidacy ADD CONSTRAINT FK_FDFFB8B159B22434 FOREIGN KEY (candidacy_id) REFERENCES candidacy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
        $this->addSql('ALTER TABLE announcement_candidate DROP FOREIGN KEY FK_EC7D6068913AEA17');
        $this->addSql('ALTER TABLE announcement_candidate DROP FOREIGN KEY FK_EC7D606891BD8781');
        $this->addSql('DROP TABLE announcement_candidate');
        $this->addSql('ALTER TABLE candidacy ADD id_candidate_id INT NOT NULL, ADD id_job_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D1740A4E7 FOREIGN KEY (id_job_offer_id) REFERENCES job_offer (id)');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569DB27CF2F3 FOREIGN KEY (id_candidate_id) REFERENCES candidate (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D930569DB27CF2F3 ON candidacy (id_candidate_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D930569D1740A4E7 ON candidacy (id_job_offer_id)');
    }
}
