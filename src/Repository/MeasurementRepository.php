<?php

namespace App\Repository;

use App\Entity\Sensor;
use Doctrine\ORM\Tools\Pagination\Paginator;

class MeasurementRepository extends AbstractRepository {
  
  public function getAll(array $params): array {
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder
      ->select("e.id, e.measure, e.createdAt, e.updatedAt, e.deletedAt")
      ->from($this->entityName, "e")
      ->join(Sensor::class, "s")
      ->where($params["includeDeleted"] ?? false ? "1 = 1" : "e.deletedAt IS NULL")
      ->orderBy("e.createdAt", "DESC")
      ->setFirstResult($params["offset"] ?? 0)
      ->setMaxResults($params["limit"] ?? 50);
    
    if(isset($params["dateLimit"])){
      $queryBuilder->andWhere("e.createdAt < :dateLimit");
      $queryBuilder->setParameter("dateLimit", $params["dateLimit"]);
    }
    
    if(isset($params["sensorId"])){
      $queryBuilder->andWhere("s.id = :sensorId");
      $queryBuilder->setParameter("sensorId", $params["sensorId"]->toBinary());
    }
    
    $paginator = new Paginator($queryBuilder);
    $paginator->setUseOutputWalkers(false);
    
    return [
      "count" => count($paginator),
      "datas" => $paginator->getQuery()->getResult()
    ];
  }
  
}