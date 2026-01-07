<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 2000)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(length: 80, nullable: true)]
    private ?string $status = null;

    /**
     * @var Collection<int, TicketCategory>
     */
    #[ORM\OneToMany(targetEntity: TicketCategory::class, mappedBy: 'event')]
    private Collection $ticketCategories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgPath = null;

    public function __construct()
    {
        $this->ticketCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, TicketCategory>
     */
    public function getTicketCategories(): Collection
    {
        return $this->ticketCategories;
    }

    public function addTicketCategory(TicketCategory $ticketCategory): static
    {
        if (!$this->ticketCategories->contains($ticketCategory)) {
            $this->ticketCategories->add($ticketCategory);
            $ticketCategory->setEvent($this);
        }

        return $this;
    }

    public function removeTicketCategory(TicketCategory $ticketCategory): static
    {
        if ($this->ticketCategories->removeElement($ticketCategory)) {
            // set the owning side to null (unless already changed)
            if ($ticketCategory->getEvent() === $this) {
                $ticketCategory->setEvent(null);
            }
        }

        return $this;
    }

    public function getImgPath(): ?string
    {
        return $this->imgPath;
    }

    public function setImgPath(?string $imgPath): static
    {
        $this->imgPath = $imgPath;

        return $this;
    }
}