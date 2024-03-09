<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304202939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement_candidate DROP FOREIGN KEY FK_EC7D6068913AEA17');
        $this->addSql('ALTER TABLE announcement_candidate DROP FOREIGN KEY FK_EC7D606891BD8781');
        $this->addSql('DROP TABLE announcement_candidate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement_candidate (announcement_id INT NOT NULL, candidate_id INT NOT NULL, INDEX IDX_EC7D6068913AEA17 (announcement_id), INDEX IDX_EC7D606891BD8781 (candidate_id), PRIMARY KEY(announcement_id, candidate_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE announcement_candidate ADD CONSTRAINT FK_EC7D6068913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement_candidate ADD CONSTRAINT FK_EC7D606891BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
    }
}
