<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301200927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT DEFAULT NULL, job_title VARCHAR(255) NOT NULL, work_place VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_valid TINYINT(1) NOT NULL, INDEX IDX_4DB9D91C156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announcement_candidacy (announcement_id INT NOT NULL, candidacy_id INT NOT NULL, INDEX IDX_FDFFB8B1913AEA17 (announcement_id), INDEX IDX_FDFFB8B159B22434 (candidacy_id), PRIMARY KEY(announcement_id, candidacy_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
        $this->addSql('ALTER TABLE announcement_candidacy ADD CONSTRAINT FK_FDFFB8B1913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement_candidacy ADD CONSTRAINT FK_FDFFB8B159B22434 FOREIGN KEY (candidacy_id) REFERENCES candidacy (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C156BE243');
        $this->addSql('ALTER TABLE announcement_candidacy DROP FOREIGN KEY FK_FDFFB8B1913AEA17');
        $this->addSql('ALTER TABLE announcement_candidacy DROP FOREIGN KEY FK_FDFFB8B159B22434');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE announcement_candidacy');
    }
}
