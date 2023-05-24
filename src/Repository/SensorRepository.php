<?php

namespace App\Repository;

use App\Entity\Module;
use Doctrine\ORM\Tools\Pagination\Paginator;

class SensorRepository extends AbstractRepository {
  
  public function getAll(array $params): array {
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder
      ->select("e.id")
      ->from($this->entityName, "e")
      ->where($params["includeDeleted"] ?? false ? "1 = 1" : "e.deletedAt IS NULL")
      ->setFirstResult($params["offset"] ?? 0)
      ->setMaxResults($params["limit"] ?? 50);
    
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
      $queryBuilder->setParameter("moduleId", $params["moduleId"]);
    }
      
    $paginator = new Paginator($queryBuilder);
    
    return [
      "count" => count($paginator),
      "datas" => $paginator->getQuery()->getResult()
    ];
  }
  
}