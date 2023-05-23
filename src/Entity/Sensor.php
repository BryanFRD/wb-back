<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor extends BaseEntity {
  
  #[ORM\Column(length: 255)]
  protected string $name;
  
  #[ORM\Column(type: "status_enum")]
  protected Status $status = Status::INACTIVE;
  
  #[ORM\Column]
  protected string $measurementType;
  
  #[ORM\Column]
  protected bool $simulated = true;
  
  #[ORM\Column]
  protected float $simulationMinimum = 0;
  
  #[ORM\Column]
  protected float $simulationMaximum = 100;
  
  #[ORM\ManyToOne(targetEntity: Module::class, inversedBy: "sensor")]
  protected ?Module $module;
  
  #[ORM\OneToMany(targetEntity: Measurement::class, mappedBy: "measurement")]
  protected ?Collection $measurements;
  
  public function getName(): string {
    return $this->name;
  }
  
  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }
  
  public function getStatus(): Status {
    return $this->status;
  }
  
  public function setStatus(Status $status): self {
    $this->status = $status;
    return $this;
  }
  
  public function getMeasurementType(): string {
    return $this->measurementType;
  }
  
  public function setMeasurementType(string $measurementType): self {
    $this->measurementType = $measurementType;
    return $this;
  }
  
  public function isSimulated(): bool {
    return $this->simulated;
  }
  
  public function setSimulated(bool $simulated): self {
    $this->simulated = $simulated;
    return $this;
  }
  
  public function getSimulationMinimum(): float {
    return $this->simulationMinimum;
  }
  
  public function setSimulationMinimum(float $simulationMinimum): self {
    $this->simulationMinimum = $simulationMinimum;
    return $this;
  }
  
  public function getSimulationMaximum(): float {
    return $this->simulationMaximum;
  }
  
  public function setSimulationMaximum(float $simulationMaximum): self {
    $this->simulationMaximum = $simulationMaximum;
    return $this;
  }
  
  public function getModule(): Module {
    return $this->module;
  }
  
  public function setModule(Module $module): self {
    $this->module = $module;
    return $this;
  }
  
  public function getMeasurements(): ?Collection {
    return $this->measurements;
  }
  
}