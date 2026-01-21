<?php

namespace App\Entity;

use App\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TicketRepository;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket extends AbstractEntity
{
  const PENDING_STATUS = 'pending';

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\ManyToOne(inversedBy: 'tickets')]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $buyer = null;

  #[ORM\ManyToOne(inversedBy: 'tickets')]
  private ?TicketCategory $category = null;

  #[ORM\Column(length: 5000, nullable: true)]
  private ?string $QRCode = null;

  #[ORM\Column(length: 80)]
  private ?string $status = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $checkedInAt = null;

  #[ORM\ManyToOne(inversedBy: 'tickets')]
  private ?Booking $booking = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getBuyer(): ?User
  {
    return $this->buyer;
  }

  public function setBuyer(?User $buyer): static
  {
    $this->buyer = $buyer;
    return $this;
  }

  public function getCategory(): ?TicketCategory
  {
    return $this->category;
  }

  public function setCategory(?TicketCategory $category): static
  {
    $this->category = $category;
    return $this;
  }

  public function getQRCode(): ?string
  {
    return $this->QRCode;
  }

  public function setQRCode(?string $QRCode): static
  {
    $this->QRCode = $QRCode;
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

  public function getCheckedInAt(): ?\DateTimeImmutable
  {
    return $this->checkedInAt;
  }

  public function setCheckedInAt(\DateTimeImmutable $checkedInAt): static
  {
    $this->checkedInAt = $checkedInAt;
    return $this;
  }

  public function getBooking(): ?Booking
  {
      return $this->booking;
  }

  public function setBooking(?Booking $booking): static
  {
      $this->booking = $booking;

      return $this;
  }
}