<?php

namespace App\Service;

use App\Entity\Measurement;
use App\Repository\MeasurementRepository;
use App\Validator\MeasurementValidator;
use Symfony\Component\Uid\Ulid;

class MeasurementService extends AbstractRepositoryService {
  
  protected SensorService $sensorService;
  
  public function __construct(MeasurementRepository $repository, MeasurementValidator $validator, SensorService $sensorService){
    parent::__construct($repository, $validator);
    $this->sensorService = $sensorService;
  }
  
  public function save(array $body, bool $flush = true): ?object {
    //TODO Validate body
    
    $sensor = $this->sensorService->getById($body["sensorId"]);
    
    $entity = new Measurement();
    $entity
      ->setMeasure($body["measure"])
      ->setSensor($sensor)
      ->updateTimestamps();
      
    $this->repository->save($entity, $flush);
    
    return $entity;
  }
  
  public function update(Ulid|string $id, array $body, bool $flush = true): ?object {
    //TODO Validate body
    
    $entity = $this->getById($id);
    if($entity){
      if(isset($body["measure"])){
        $entity->setMeasure($body["measure"]);
      }
      
      if(isset($body["sensorId"])){
        $sensor = $this->sensorService->getById($body["sensorId"]);
        
        $entity->setSensor($sensor);
      }
    }
    
    $this->repository->flush();
    
    return $entity;
  }
  
}