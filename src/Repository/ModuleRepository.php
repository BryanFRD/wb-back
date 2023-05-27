<?php

namespace App\Repository;

use App\Entity\Sensor;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ModuleRepository extends AbstractRepository {
  
  public function getAll(array $params): array {
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder
      ->select("e.id, e.name, e.status, e.createdAt, e.updatedAt, e.deletedAt, COUNT(s) AS sensorCount")
      ->from($this->entityName, "e")
      ->join(Sensor::class, "s")
      ->groupBy("e.id")
      ->where($params["includeDeleted"] ?? false ? "1 = 1" : "e.deletedAt IS NULL")
      ->setFirstResult($params["offset"] ?? 0)
      ->setMaxResults($params["limit"] ?? 50);
      
    if(isset($params["search"])){
      $queryBuilder->andWhere("e.name LIKE :search");
      $queryBuilder->setParameter("search", "%" . $params["search"] . "%");
    }
    
    if(isset($params["status"])){
      $queryBuilder->andWhere("e.status = :status");
      $queryBuilder->setParameter("status", $params["status"]);
    }
    
    $paginator = new Paginator($queryBuilder);
    $paginator->setUseOutputWalkers(false);
    
    return [
      "count" => count($paginator),
      "datas" => $paginator->getQuery()->getResult()
    ];
  }
  
}