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
  
  #[ORM\Column(name: "created_at")]
  protected DateTime $createdAt; 
  
  #[ORM\Column(name: "updated_at")]
  protected DateTime $updatedAt; 
  
  #[ORM\Column(name: "deleted_at")]
  protected ?DateTime $deletedAt;
  
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
  
}