<?php

namespace App\Entity;

use App\Repository\SpeedMeasurementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeedMeasurementRepository::class)]
class SpeedMeasurement extends MeasurementEntity {
  
  #[ORM\Column]
  protected float $speed;
  
  #[Orm\ManyToOne(targetEntity: Module::class, inversedBy: "speedMeasurement")]
  protected Module $module;
  
  public function getSpeed(): float {
    return $this->speed;
  }
  
  public function getModule(): Module {
    return $this->module;
  }
  
  public function setSpeed(float $speed): void {
    $this->speed = $speed;
  }
  
}