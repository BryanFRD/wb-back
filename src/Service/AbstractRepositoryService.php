<?php

namespace App\Service;

use App\Repository\AbstractRepository;
use App\Validator\AbstractValidator;
use Symfony\Component\Uid\Ulid;

abstract class AbstractRepositoryService {
  
  protected AbstractRepository $repository;
  protected AbstractValidator $validator;
  
  public function __construct(AbstractRepository $repository, AbstractValidator $validator){
    $this->repository = $repository;
    $this->validator = $validator;
  }
  
  public function getAll(array $params): array {
    //TODO Validate params
    
    return $this->repository->getAll($params);
  }
  
  public function getById(Ulid|string|null $id): ?object {
    if($id === null){
      return null;
    }
    
    if($id instanceof string){
      $id = Ulid::fromString($id);
    }
    
    return $this->repository->getById($id);
  }
  
  public function flush(): void {
    $this->repository->flush();
  }
  
  public abstract function save(array $body, bool $flush = true): ?object;
  
  public abstract function update(Ulid|string $id, array $body, bool $flush = true): ?object;
  
  public function delete(Ulid|string $id, bool $flush = true, bool $soft = true): bool {
    $entity = $this->getById($id);
    
    return $this->repository->remove($entity, $flush, $soft);
  }
  
}