<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class AbstractEntity
{
  #[ORM\Column(type: 'datetime_immutable')]
  protected ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(type: 'datetime_immutable', nullable: true)]
  protected ?\DateTimeImmutable $updatedAt = null;

  #[ORM\Column(type: 'boolean')]
  protected bool $active = true;

  #[ORM\PrePersist]
  public function onCreate(): void
  {
    $this->createdAt = new \DateTimeImmutable();
  }

  #[ORM\PreUpdate]
  public function onUpdate(): void
  {
    $this->updatedAt = new \DateTimeImmutable();
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function isActive(): bool
  {
    return $this->active;
  }

  public function activate(): void
  {
    $this->active = true;
  }

  public function deactivate(): void
  {
    $this->active = false;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): static
  {
      $this->createdAt = $createdAt;

      return $this;
  }

  public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
  {
      $this->updatedAt = $updatedAt;

      return $this;
  }

  public function setActive(bool $active): static
  {
      $this->active = $active;

      return $this;
  }
}