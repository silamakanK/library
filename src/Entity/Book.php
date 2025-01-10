<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $publish_date = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author_id = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Genre $genre_id = null;

    /**
     * @var Collection<int, Discussion>
     */
    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'book_id')]
    private Collection $discussions;

    public function __construct()
    {
        $this->discussions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publish_date;
    }

    public function setPublishDate(\DateTimeInterface $publish_date): static
    {
        $this->publish_date = $publish_date;

        return $this;
    }

    public function getAuthorId(): ?Author
    {
        return $this->author_id;
    }

    public function setAuthorId(?Author $author_id): static
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getGenreId(): ?Genre
    {
        return $this->genre_id;
    }

    public function setGenreId(?Genre $genre_id): static
    {
        $this->genre_id = $genre_id;

        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): static
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions->add($discussion);
            $discussion->setBookId($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getBookId() === $this) {
                $discussion->setBookId(null);
            }
        }

        return $this;
    }
}
