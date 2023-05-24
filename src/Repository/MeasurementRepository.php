<?php

namespace App\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

class MeasurementRepository extends AbstractRepository {
  
  public function getAll(array $params): array {
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder
      ->select("e")
      ->from($this->entityName, "e")
      ->where($params["includeDeleted"] ?? false ? "1 = 1" : "e.deletedAt IS NULL")
      ->setFirstResult($params["offset"] ?? 0)
      ->setMaxResults($params["limit"] ?? 50);
    
    if(isset($params["dateLimit"])){
      $queryBuilder->andWhere("e.createdAt < :dateLimit");
      $queryBuilder->setParameter("dateLimit", $params["dateLimit"]);
    }
    
    if(isset($params["sensorId"])){
      $queryBuilder->andWhere("e.sensorId = :sensorId");
      $queryBuilder->setParameter("sensorId", $params["sensorId"]);
    }
    
    $paginator = new Paginator($queryBuilder);
    
    return [
      "count" => count($paginator),
      "datas" => $paginator->getQuery()->getResult()
    ];
  }
  
}