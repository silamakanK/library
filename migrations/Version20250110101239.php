<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250110101239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE author (id SERIAL NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, biography TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book (id SERIAL NOT NULL, author_id_id INT NOT NULL, genre_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, publish_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A33169CCBE9A ON book (author_id_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331C2428192 ON book (genre_id_id)');
        $this->addSql('CREATE TABLE discussion (id SERIAL NOT NULL, user_id_id INT DEFAULT NULL, book_id_id INT NOT NULL, content TEXT NOT NULL, publish_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0B9F90F9D86650F ON discussion (user_id_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90F71868B2E ON discussion (book_id_id)');
        $this->addSql('CREATE TABLE genre (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33169CCBE9A FOREIGN KEY (author_id_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331C2428192 FOREIGN KEY (genre_id_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F71868B2E FOREIGN KEY (book_id_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A33169CCBE9A');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331C2428192');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90F9D86650F');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90F71868B2E');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE "user"');
    }
}
