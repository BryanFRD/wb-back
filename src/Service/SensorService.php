<?php

namespace App\Service;

use App\Entity\Sensor;
use App\Enum\Status;
use App\Repository\SensorRepository;
use App\Validator\SensorValidator;
use Symfony\Component\Uid\Ulid;

class SensorService extends AbstractRepositoryService {
  
  protected ModuleService $moduleService;
  
  public function __construct(SensorRepository $repository, SensorValidator $validator, ModuleService $moduleService){
    parent::__construct($repository, $validator);
    $this->moduleService = $moduleService;
  }
  
  public function save(array $body, bool $flush = true): ?object {
    //TODO Validate $params
    
    $module = $this->moduleService->getById($body["moduleId"]);
    
    $entity = new Sensor();
    $entity
      ->setName($body["name"])
      ->setStatus(Status::from($body["status"]))
      ->setMeasurementType($body["measurementType"])
      ->setSimulated($body["simulated"])
      ->setSimulationMinimum($body["simulationMinimum"])
      ->setSimulationMaximum($body["simulationMaximum"])
      ->setModule($module)
      ->updateTimestamps();
      
    $this->repository->save($entity, $flush);
    
    return $entity;
  }
  
  public function update(Ulid|string $id, array $body, bool $flush = true): ?object {
    //TODO Validate body
    
    $entity = $this->getById($id);
    if($entity){
      if(isset($body["name"])){
        $entity->setName($body["name"]);
      }
      
      if(isset($body["status"])){
        $entity->setStatus(Status::from($body["status"]));
      }
      
      if(isset($body["measurementType"])){
        $entity->setMeasurementType($body["measurementType"]);
      }
      
      if(isset($body["simulated"])){
        $entity->setSimulated($body["simulated"]);
      }
      
      if(isset($body["simulationMinimum"])){
        $entity->setSimulationMinimum($body["simulationMinimum"]);
      }
      
      if(isset($body["simulationMaximum"])){
        $entity->setSimulationMaximum($body["simulationMaximum"]);
      }
      
      if(isset($body["moduleId"])){
        $module = $this->moduleService->getById($body["moduleId"]);
        $entity->setModule($module);
      }
    }
    
    $this->repository->flush();
    
    return $entity;
  }
  
}