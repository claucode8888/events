<?php

namespace App\Entity;

use App\Entity\AbstractEntity;
use App\Entity\Organizer;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Index(name:'idx_event_status', columns: ['status'])]
#[ORM\Index(name:'idx_event_start_at', columns: ['start_at'])]
#[ORM\Index(name:'idx_event_end_at', columns: ['end_at'])]
#[ORM\HasLifecycleCallbacks]
class Event extends AbstractEntity
{
    const STATUS_PUBLISHED = 'published';
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Please enter a name for the Event.')]
    private ?string $name = null;

    #[ORM\Column(length: 2000)]
    #[Assert\NotBlank(message: 'Please enter a decription.')]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacity = null;

    #[ORM\Column(length: 80, nullable: false)]
    #[Assert\NotBlank(message: 'Please select one status.')]
    private ?string $status = null;

    /**
     * @var Collection<int, TicketCategory>
     */
    #[Assert\Valid]
    #[Assert\Count(min: 1, minMessage: 'You must add at least one ticket category.')]
    #[ORM\OneToMany(targetEntity: TicketCategory::class, mappedBy: 'event', cascade: ['persist',  'remove'], orphanRemoval: true)]
    private Collection $ticketCategories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgPath = null;

    #[ORM\Column(length: 255)]
    private ?string $location = 'Luna Park';

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'events', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organizer $organizer = null;

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

    public function isTotallyFree() : bool
    {
      foreach($this->ticketCategories as $tc)
      {
        if(!$tc->isFree())
        {
          return false;
        }
      }
      return true;
    }

    public function hasAvailability() : int
    {
      $availability = 0;
      foreach($this->ticketCategories as $TC)
      {
        $availability += $TC->ticketsAvailability();
      }
      return $availability;
    }

    public function isSoldOut(): bool
    {
      foreach($this->ticketCategories as $TC)
      {
        if(!$TC->isSoldOut())
        {
          return false;
        }
      }
      return true;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

  #[ORM\PrePersist]
  #[ORM\PreUpdate]
  public function calculateCapacity(): void
  {
    $total = 0;
    foreach ($this->getTicketCategories() as $category) {
      $total += $category->getQuantity();
    }
    $this->capacity = $total;
  }

  public function setCapacity(?int $capacity): static
  {
      $this->capacity = $capacity;

      return $this;
  }

  public function getOrganizer(): ?Organizer
  {
      return $this->organizer;
  }

  public function setOrganizer(?Organizer $organizer): static
  {
      $this->organizer = $organizer;

      return $this;
  }

  public function getStatus(): ?string
  {
      return $this->status;
  }

  public function setStatus(string $status): static
  {
      $this->status = $status;

      return $this;
  }
}