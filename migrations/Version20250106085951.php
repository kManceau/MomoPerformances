<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106085951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, upload_by_id INT NOT NULL, related_to_id INT NOT NULL, filename VARCHAR(100) NOT NULL, upload_date DATE NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_D5FC5D9C83BA6D1B (upload_by_id), INDEX IDX_D5FC5D9C40B4AC4E (related_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9C83BA6D1B FOREIGN KEY (upload_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9C40B4AC4E FOREIGN KEY (related_to_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9C83BA6D1B');
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9C40B4AC4E');
        $this->addSql('DROP TABLE archive');
    }
}
