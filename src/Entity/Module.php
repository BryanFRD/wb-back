<?php

namespace App\Entity;

use App\Doctrine\Type\StatusEnumType;
use App\Enum\Status;
use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module extends BaseEntity {
  
  #[ORM\Column(length: 255)]
  protected string $name;
  
  #[ORM\Column(type: "status_enum")]
  protected Status $status = Status::INACTIVE;
  
  #[ORM\OneToMany(targetEntity: SpeedMeasurement::class, mappedBy: "speedMeasurement")]
  protected ?Collection $speedMeasurements;
  
  #[ORM\OneToMany(targetEntity: SpeedMeasurement::class, mappedBy: "temperatureMeasurement")]
  protected ?Collection $temperatureMeasurements;
  
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
  
  public function getSpeedMeasurements(): ?Collection {
    return $this->speedMeasurements;
  }
  
  public function getTemperatureMeasurements(): ?Collection {
    return $this->temperatureMeasurements;
  }
  
}