<?php 

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

abstract class MeasurementEntity {
  
  #[ORM\Id]
  #[ORM\GeneratedValue("SEQUENCE")]
  #[ORM\SequenceGenerator(sequenceName: "id")]
  #[ORM\Column]
  protected ?int $id = null;
  
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
  
  public function getId(): ?int {
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