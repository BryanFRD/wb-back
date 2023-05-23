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