<?php

namespace App\Entity;

use App\Repository\TemperatureMeasurementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemperatureMeasurementRepository::class)]
class TemperatureMeasurement extends MeasurementEntity {
  
  #[ORM\Column]
  protected float $temperature;
  
  #[Orm\ManyToOne(targetEntity: Module::class, inversedBy: "temperatureMeasurement")]
  protected Module $module;
  
  public function getTemperature(): float {
    return $this->temperature;
  }
  
  public function getModule(): Module {
    return $this->module;
  }
  
  public function setTemperature(float $temperature): void {
    $this->temperature = $temperature;
  }
  
}