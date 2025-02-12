<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Genre;
use App\Entity\User;
use App\Enum\GenderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public const MAX_USERS = 10;
    public const MAX_AUTHORS = 10;
    public const BOOK_PER_AUTHOR = 3;
    public const MAX_DISCUSSIONS_PER_USER = 3;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

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
//        $this->createDiscussions($manager, $discussions, $users, $books);

        $manager->flush();
    }

   protected function createUsers(ObjectManager $manager, array &$users): void
    {
        for ($i = 0; $i < self::MAX_USERS; $i++) {
            $user = new User();
            $user->setEmail(email: "user{$i}@example.com");
            $user->setFullName(full_name: "test_{$i}");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'passer'));            $user->setRoles(roles: ['USER']);
            $user->setGender(GenderStatus::MALE);
            $user->setRoles(['ROLE_USER']);
            $users[] = $user;

            $manager->persist(object: $user);
        }

        $admin = new User();
        $admin->setEmail(email: "lastadmin@example.com");
        $admin->setFullName(full_name: "Le Boss");
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'lastadmin'));
        $admin->setGender(GenderStatus::MALE);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $banned = new User();
        $banned->setEmail("banned@example.com");
        $banned->setFullName("Banned User");
        $banned->setPassword($this->passwordHasher->hashPassword($banned, 'banned'));
        $banned->setRoles(['ROLE_BANNED']);
        $banned->setGender(GenderStatus::FEMALE);
        $manager->persist($banned);
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
                $book->addAuthor($author);
                $book->setGenre($genres[array_rand($genres)]);
                $book->setPicture(picture: 'https://imgs.search.brave.com/47UumTPxdAqJ7RACY2hm_gdia8Pz_A_cMh4O612bNaY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/Y3VsdHVyYS5jb20v/Y2RuLWNnaS9pbWFn/ZS93aWR0aD0yNTAv/bWVkaWEvcGltL1RJ/VEVMSVZFLzQ2Xzk3/ODI4OTIyNTk1NTFf/MV83NS5qcGc');
                $books[] = $book;

                $manager->persist(object: $book);
            }
        }
    }

    protected function createAuthors(ObjectManager $manager, array &$authors): void
    {
        for ($i = 0; $i < self::MAX_AUTHORS; $i++) {
            $author = new Author();
            $author->setFullName(full_name: "Author {$i}");
            $author->setGender(gender: GenderStatus::MALE);
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

    /*protected function createDiscussions(ObjectManager $manager, array &$discussions, array &$users, array &$books): void
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

    }*/
}
