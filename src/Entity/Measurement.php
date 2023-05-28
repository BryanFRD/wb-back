<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement extends AbstractEntity {
  
  //TODO Validate values
  
  #[ORM\Column]
  protected float $measure;
  
  #[ORM\ManyToOne(targetEntity: Sensor::class, inversedBy: "measurements")]
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
  
  public function jsonSerialize(): mixed {
    return array_merge(parent::jsonSerialize(),
      array(
        "measure" => $this->getMeasure()
      ),
    );
  }
  
}