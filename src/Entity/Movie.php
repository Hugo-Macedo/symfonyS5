<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ApiResource(
    normalizationContext: ['groups' => ['movie:read']],
    description: 'A movie with actors.',
    operations: [
        new Get(uriTemplate: '/movie/{id}'),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ]
)]
#[Get]
#[Put(security: "is_granted('ROLE_ADMIN')")]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[Security("is_granted('ROLE_USER')")]

#[ORM\Entity(repositoryClass: MovieRepository::class)]


#[ApiFilter(BooleanFilter::class, properties: ['online'])]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial', 'description' => 'partial', 'id' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ["releaseDate" => "DESC"])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['movie:read'])]
    #[Assert\Type('boolean')]
    private ?bool $online;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?Category $category;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    private ?string $title;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['movie:read', 'category:read'])]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, maxMessage: 'Describe the movie in up to 255 characters', minMessage: 'too short')]
    private ?string $description;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['movie:read', 'category:read'])]
    #[Assert\Type('integer')]
    private ?int $duration = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['movie:read', 'category:read'])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    #[Assert\NotBlank]
    private Collection $actors;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read'])]
    #[Assert\Type('integer')]
    private ?int $entries = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')]
    #[Groups(['movie:read'])]
    private ?int $note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): static
    {
        $this->online = $online;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
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
    

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): static    
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(actor $actor): static
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }

        return $this;
    }

    public function removeActor(actor $actor): static
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    public function getEntries(): ?int
    {
        return $this->entries;
    }

    public function setEntries(?int $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
