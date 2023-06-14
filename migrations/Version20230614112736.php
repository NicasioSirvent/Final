<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614112736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE passenger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE captain (id INT NOT NULL, captain_license_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, number VARCHAR(255) NOT NULL, from_airport VARCHAR(255) NOT NULL, to_airport VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE passenger (id INT NOT NULL, seat INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE passenger_flight (passenger_id INT NOT NULL, flight_id INT NOT NULL, PRIMARY KEY(passenger_id, flight_id))');
        $this->addSql('CREATE INDEX IDX_86C9D5494502E565 ON passenger_flight (passenger_id)');
        $this->addSql('CREATE INDEX IDX_86C9D54991F478C5 ON passenger_flight (flight_id)');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, name VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE steward (id INT NOT NULL, flight_id INT DEFAULT NULL, air_crew_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_69A6252591F478C5 ON steward (flight_id)');
        $this->addSql('ALTER TABLE captain ADD CONSTRAINT FK_AE35BF5BBF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE passenger_flight ADD CONSTRAINT FK_86C9D5494502E565 FOREIGN KEY (passenger_id) REFERENCES passenger (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE passenger_flight ADD CONSTRAINT FK_86C9D54991F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE steward ADD CONSTRAINT FK_69A6252591F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE steward ADD CONSTRAINT FK_69A62525BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE passenger_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('ALTER TABLE captain DROP CONSTRAINT FK_AE35BF5BBF396750');
        $this->addSql('ALTER TABLE passenger_flight DROP CONSTRAINT FK_86C9D5494502E565');
        $this->addSql('ALTER TABLE passenger_flight DROP CONSTRAINT FK_86C9D54991F478C5');
        $this->addSql('ALTER TABLE steward DROP CONSTRAINT FK_69A6252591F478C5');
        $this->addSql('ALTER TABLE steward DROP CONSTRAINT FK_69A62525BF396750');
        $this->addSql('DROP TABLE captain');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE passenger');
        $this->addSql('DROP TABLE passenger_flight');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE steward');
    }
}
