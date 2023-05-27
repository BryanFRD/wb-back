<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

abstract class AbstractEntity implements JsonSerializable {
  
  //TODO Validate values
  
  #[ORM\Id]
  #[ORM\GeneratedValue("CUSTOM")]
  #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
  #[ORM\Column(type: UlidType::NAME, unique: true)]
  protected ?Ulid $id = null;
  
  #[ORM\Column(updatable: false)]
  protected DateTime $createdAt;
  
  #[ORM\Column]
  protected DateTime $updatedAt;
  
  #[ORM\Column(nullable: true)]
  protected ?DateTime $deletedAt = null;
  
  #[ORM\PrePersist]
  #[ORM\PreUpdate]
  public function updateTimestamps(): void {
    if(empty($this->createdAt)){
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
  
  public function jsonSerialize(): mixed {
    return array(
      "id" => $this->getId(),
      "createdAt" => $this->getCreatedAt(),
      "updatedAt" => $this->getUpdatedAt(),
      "deletedAt" => $this->getDeletedAt(),
    );
  }
  
}