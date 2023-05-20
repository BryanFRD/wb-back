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