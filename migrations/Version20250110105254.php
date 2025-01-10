<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250110105254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book DROP CONSTRAINT fk_cbe5a33169ccbe9a');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT fk_cbe5a331c2428192');
        $this->addSql('DROP INDEX idx_cbe5a331c2428192');
        $this->addSql('DROP INDEX idx_cbe5a33169ccbe9a');
        $this->addSql('ALTER TABLE book ADD genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD number_of_copy INT NOT NULL');
        $this->addSql('ALTER TABLE book DROP genre_id_id');
        $this->addSql('ALTER TABLE book RENAME COLUMN author_id_id TO author_id');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3314296D31F ON book (genre_id)');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT fk_c0b9f90f9d86650f');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT fk_c0b9f90f71868b2e');
        $this->addSql('DROP INDEX idx_c0b9f90f71868b2e');
        $this->addSql('DROP INDEX idx_c0b9f90f9d86650f');
        $this->addSql('ALTER TABLE discussion ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE discussion DROP user_id_id');
        $this->addSql('ALTER TABLE discussion RENAME COLUMN book_id_id TO book_id');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C0B9F90F16A2B381 ON discussion (book_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FFB88E14F ON discussion (utilisateur_id)');
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90F16A2B381');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90FFB88E14F');
        $this->addSql('DROP INDEX IDX_C0B9F90F16A2B381');
        $this->addSql('DROP INDEX IDX_C0B9F90FFB88E14F');
        $this->addSql('ALTER TABLE discussion ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discussion ADD book_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE discussion DROP book_id');
        $this->addSql('ALTER TABLE discussion DROP utilisateur_id');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT fk_c0b9f90f9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT fk_c0b9f90f71868b2e FOREIGN KEY (book_id_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c0b9f90f71868b2e ON discussion (book_id_id)');
        $this->addSql('CREATE INDEX idx_c0b9f90f9d86650f ON discussion (user_id_id)');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3314296D31F');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B');
        $this->addSql('DROP INDEX IDX_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE book ADD author_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD genre_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book DROP author_id');
        $this->addSql('ALTER TABLE book DROP genre_id');
        $this->addSql('ALTER TABLE book DROP number_of_copy');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT fk_cbe5a33169ccbe9a FOREIGN KEY (author_id_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT fk_cbe5a331c2428192 FOREIGN KEY (genre_id_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_cbe5a331c2428192 ON book (genre_id_id)');
        $this->addSql('CREATE INDEX idx_cbe5a33169ccbe9a ON book (author_id_id)');
    }
}
