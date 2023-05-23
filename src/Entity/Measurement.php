<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement extends BaseEntity {
  
  #[ORM\Column]
  protected float $measure;
  
  #[ORM\ManyToOne(targetEntity: Sensor::class, inversedBy: "measurement")]
  protected Sensor $sensor;
  
  public function getMeasure(): float {
    return $this->measure;
  }
  
  public function setMeasure(float $measure): self {
    $this->measure = $measure;
    return $this;
  }
  
  public function getSensor(): Sensor {
    return $this->sensor;
  }
  
  public function setSensor(Sensor $sensor): self {
    $this->sensor = $sensor;
    return $this;
  }
  
}