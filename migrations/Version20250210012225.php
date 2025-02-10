<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210012225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id SERIAL NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, biography TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book (id SERIAL NOT NULL, author_id INT NOT NULL, genre_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, publish_date DATE NOT NULL, number_of_copy INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3314296D31F ON book (genre_id)');
        $this->addSql('CREATE TABLE borrow (id SERIAL NOT NULL, book_id INT DEFAULT NULL, utilisateur_id INT NOT NULL, borrowed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, due_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, returned_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_55DBA8B016A2B381 ON borrow (book_id)');
        $this->addSql('CREATE INDEX IDX_55DBA8B0FB88E14F ON borrow (utilisateur_id)');
        $this->addSql('COMMENT ON COLUMN borrow.borrowed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN borrow.due_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN borrow.returned_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE discussion (id SERIAL NOT NULL, book_id INT NOT NULL, utilisateur_id INT NOT NULL, content TEXT NOT NULL, publish_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0B9F90F16A2B381 ON discussion (book_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FFB88E14F ON discussion (utilisateur_id)');
        $this->addSql('CREATE TABLE genre (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles TEXT NOT NULL, username VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE borrow DROP CONSTRAINT FK_55DBA8B016A2B381');
        $this->addSql('ALTER TABLE borrow DROP CONSTRAINT FK_55DBA8B0FB88E14F');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90F16A2B381');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90FFB88E14F');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE borrow');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
