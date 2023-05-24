<?php

namespace App\Service;

use App\Entity\Module;
use App\Enum\Status;
use App\Repository\ModuleRepository;
use App\Validator\ModuleValidator;
use Symfony\Component\Uid\Ulid;

class ModuleService extends AbstractRepositoryService {
  
  public function __construct(ModuleRepository $repository, ModuleValidator $validator){
    parent::__construct($repository, $validator);
  }
  
  public function save(array $body, bool $flush = true): ?object {
    //TODO Validate $params
    
    $entity = new Module();
    $entity
      ->setName($body["name"])
      ->setStatus(Status::from($body["status"]));
      
    $this->repository->save($entity, $flush);
    
    return $entity;
  }
  
  public function update(Ulid|string $id, array $body, bool $flush = true): ?object {
    //TODO Validate body
    
    $entity = $this->getById($body["id"]);
    if($entity){
      if(isset($body["name"])){
        $entity->setName($body["name"]);
      }
      
      if(isset($body["status"])){
        $entity->setStatus(Status::from($body["status"]));
      }
    }
    
    if($flush){
      $this->repository->flush();
    }
    
    return $entity;
  }
  
}