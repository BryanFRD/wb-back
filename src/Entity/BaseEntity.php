<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

abstract class BaseEntity {
  
  #[ORM\Id]
  #[ORM\GeneratedValue("CUSTOM")]
  #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
  #[ORM\Column(type: UlidType::NAME, unique: true)]
  protected ?Ulid $id = null;
  
  #[ORM\Column]
  protected DateTime $createdAt; 
  
  #[ORM\Column]
  protected DateTime $updatedAt; 
  
  #[ORM\Column]
  protected ?DateTime $deletedAt = null;
  
  #[ORM\PrePersist]
  #[ORM\PreUpdate]
  public function updateTimestamps(): void {
    if($this->createdAt === null){
      $this->createdAt = new DateTime();
    }
    $this->updatedAt = new DateTime();
  }
  
  public function softDelete(): void {
    $this->deletedAt = new DateTime();
  }
  
  public function getId(): ?Ulid {
    return $this->id;
  }
  
  public function getCreatedAt(): DateTime {
    return $this->createdAt;
  }
  
  public function getUpdatedAt(): DateTime {
    return $this->updatedAt;
  }
  
  public function getDeletedAt(): ?DateTime {
    return $this->deletedAt;
  }
  
}