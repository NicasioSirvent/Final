<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614114139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight ADD captain_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E3346729B FOREIGN KEY (captain_id) REFERENCES captain (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C257E60E3346729B ON flight (captain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E3346729B');
        $this->addSql('DROP INDEX UNIQ_C257E60E3346729B');
        $this->addSql('ALTER TABLE flight DROP captain_id');
    }
}
