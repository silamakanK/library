<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Discussion;
use App\Entity\Author;
use App\Entity\Genre;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public const MAX_USERS = 10;
    public const MAX_AUTHORS = 10;
    public const BOOK_PER_AUTHOR = 3;
    public const MAX_DISCUSSIONS_PER_USER = 3;

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $authors = [];
        $genres = [];
        $books = [];
        $discussions = [];

        $this->createUsers($manager, $users);
        $this->createAuthors($manager, $authors);
        $this->createGenres($manager, $genres);
        $this->createBooks($manager, $books, $authors, $genres);
        $this->createDiscussions($manager, $discussions, $users, $books);

        $manager->flush();

    }

    protected function createUsers(ObjectManager $manager, array &$users): void
    {
        for ($i = 0; $i < self::MAX_USERS; $i++) {
            $user = new User();
            $user->setEmail(email: "test_{$i}@example.com");
            $user->setUsername(username: "test_{$i}");
            $user->setPassword(password: 'passer');
            $user->setRoles(roles: ['USER']);
            $users[] = $user;

            $manager->persist(object: $user);
        }

        $admin = new User();
        $admin->setEmail(email: "admin@example.com");
        $admin->setUsername(username: "admin");
        $admin->setPassword('passer');
        $admin->setRoles(['ADMIN']);
        $manager->persist($admin);
    }

    protected function createBooks(ObjectManager $manager, array &$books, array &$authors, array &$genres): void
    {
        foreach ($authors as $author) {
            for ($i = 0; $i < self::BOOK_PER_AUTHOR; $i++) {
                $book = new Book();
                $book->setTitle(title: "Book {$i}");
                $book->setDescription(description: "Description du Book {$i}");
                $book->setPublishDate(new \DateTime());
                $book->setNumberOfCopy(number_of_copy: 5);
                $book->setAuthor($author);
                $book->setGenre($genres[array_rand($genres)]);
                $books[] = $book;

                $manager->persist(object: $book);
            }
        }
    }

    protected function createAuthors(ObjectManager $manager, array &$authors): void
    {
        for ($i = 0; $i < self::MAX_AUTHORS; $i++) {
            $author = new Author();
            $author->setFirstName(first_name: "Author {$i}");
            $author->setLastName(last_name: "Author {$i}");
            $author->setBiography(biography: 'Lorem Ipsum');
            $authors[] = $author;

            $manager->persist(object: $author);
        }
    }

    protected function  createGenres(ObjectManager $manager, array &$genres): void
    {
        $array = [
            ['name' => 'Manga', 'description' => 'Manga'],
            ['name' => 'Roman', 'description' => 'Roman'],
            ['name' => 'Livre d\'art', 'description' => 'Livre d\'art'],
            ['name' => 'Science-fiction', 'description' => 'Science-fiction'],
            ['name' => 'Bande dessinée', 'description' => 'Bande dessinée'],
            ['name' => 'Essai', 'description' => 'Essai'],
            ['name' => 'Biographie', 'description' => 'Biographie'],
            ['name' => 'Autobiographie', 'description' => 'Autobiographie'],
            ['name' => 'Théâtre', 'description' => 'Théâtre'],
            ['name' => 'Nouvelle', 'description' => 'Nouvelle'],
            ['name' => 'Policier', 'description' => 'Policier'],
            ['name' => 'Fantastique', 'description' => 'Fantastique'],
            ['name' => 'Horreur', 'description' => 'Horreur'],
            ['name' => 'Aventure', 'description' => 'Aventure'],
            ['name' => 'Conte', 'description' => 'Conte'],
            ['name' => 'Fable', 'description' => 'Fable'],
            ['name' => 'Mythe', 'description' => 'Mythe'],
            ['name' => 'Légende', 'description' => 'Légende'],
            ['name' => 'Épopée', 'description' => 'Épopée'],
            ['name' => 'Journal intime', 'description' => 'Journal intime'],
            ['name' => 'Lettre', 'description' => 'Lettre'],
            ['name' => 'Discours', 'description' => 'Discours'],
            ['name' => 'Article', 'description' => 'Article'],
            ['name' => 'Critique', 'description' => 'Critique'],
            ['name' => 'Éditorial', 'description' => 'Éditorial'],
            ['name' => 'Pamphlet', 'description' => 'Pamphlet'],
            ['name' => 'Plaidoyer', 'description' => 'Plaidoyer'],
            ['name' => 'Préface', 'description' => 'Préface'],
            ['name' => 'Prologue', 'description' => 'Prologue'],
            ['name' => 'Épilogue', 'description' => 'Épilogue'],
            ['name' => 'Chanson', 'description' => 'Chanson'],
            ['name' => 'Poème', 'description' => 'Poème'],
        ];

        foreach ($array as $item) {
            $genre = new Genre();
            $genre->setName(name: $item['name']);
            $genre->setDescription(description: $item['description']);
            $genres[] = $genre;

            $manager->persist(object: $genre);
        }
    }

    protected function createDiscussions(ObjectManager $manager, array &$discussions, array &$users, array &$books): void
    {
        foreach ($users as $user) {
            for ($i = 0; $i < self::MAX_DISCUSSIONS_PER_USER; $i++) {
                $discussion = new Discussion();
                $discussion->setContent(content: "Discussion {$i}");
                $discussion->setPublishDate(new \DateTime());
                $discussion->setUtilisateur($user);
                $discussion->setBook($books[array_rand($books)]);
                $discussions[] = $discussion;

                $manager->persist(object: $discussion);
            }
        }

    }
}
