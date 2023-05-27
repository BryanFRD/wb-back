<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module extends AbstractEntity {
  
  //TODO Validate values
  
  #[ORM\Column(length: 255)]
  protected string $name;
  
  #[ORM\Column(type: "status_enum")]
  protected Status $status = Status::INACTIVE;
  
  #[ORM\OneToMany(targetEntity: Sensor::class, mappedBy: "sensor")]
  protected ?Collection $sensors;
  
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
  
  public function getSensors(): ?Collection {
    return $this->sensors;
  }
  
  public function jsonSerialize(): mixed {
    return array_merge(parent::jsonSerialize(),
      array(
        "name" => $this->getName(),
        "status" => $this->getStatus(),
      ),
    );
  }
  
}