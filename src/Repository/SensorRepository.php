<?php

namespace App\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

class SensorRepository extends AbstractRepository {
  
  public function getAll(array $params): array {
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder
      ->select("e.id, e.name, e.measurementType, e.status, e.simulated, e.simulationMinimum, e.simulationMaximum, e.createdAt, e.updatedAt, e.deletedAt, m.id AS moduleId")
      ->from($this->entityName, "e")
      ->leftJoin("e.module", 'm')
      ->groupBy('e.id')
      ->where($params["includeDeleted"] ?? false ? "1 = 1" : "e.deletedAt IS NULL")
      ->setFirstResult($params["offset"] ?? 0)
      ->setMaxResults($params["limit"] ?? 50);
    
    if(isset($params["search"])){
      $queryBuilder->andWhere("e.name LIKE :search");
      $queryBuilder->setParameter("search", "%" . $params["search"] . "%");
    }
    
    if(isset($params["isSimulated"])){
      $queryBuilder->andWhere("e.simulated = :isSimulated");
      $queryBuilder->setParameter("isSimulated", $params["isSimulated"]);
    }
      
    if(isset($params["status"])){
      $queryBuilder->andWhere("e.status = :status");
      $queryBuilder->setParameter("status", $params["status"]);
    }
    
    if(isset($params["measurementType"])){
      $queryBuilder->andWhere("e.measurementType LIKE :measurementType");
      $queryBuilder->setParameter("measurementType", $params["measurementType"]);
    }
    
    if(isset($params["moduleId"])){
      $queryBuilder->andWhere("m.id = :moduleId");
      $queryBuilder->setParameter("moduleId", $params["moduleId"]->toBinary());
    }
    
    $paginator = new Paginator($queryBuilder);
    
    return [
      "count" => $paginator->count(),
      "datas" => $paginator->getQuery()->getResult()
    ];
  }
  
}