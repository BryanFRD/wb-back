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
  protected ?DateTime $deletedAt;
  
  #[ORM\PrePersist]
  #[ORM\PreUpdate]
  public function updateTimestamps(): void {
    if($this->createdAt === null){
      $this->createdAt = new DateTime();
    }
    $this->updatedAt = new DateTime();
  }
  
}