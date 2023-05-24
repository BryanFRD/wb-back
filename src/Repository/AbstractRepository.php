<?php

namespace App\Repository;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractRepository extends ServiceEntityRepository {
  
  protected $entityName;
    
  public function __construct(ManagerRegistry $registry){
    $this->entityName = preg_replace(
      ["/^App\\\Repository/", "/Repository$/"],
      ["App\\Entity"],
      get_class($this)
    );
      
    parent::__construct($registry, $this->entityName);
  }
  
  #[Assert\Collection]
  public function getAll(array $params): array {
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $queryBuilder
      ->select("e")
      ->from($this->entityName, "e")
      ->where($params["includeDeleted"] ?? false ? "1 = 1" : "e.deletedAt IS NULL")
      ->setParameters($params)
      ->setFirstResult($params["offset"] ?? 0)
      ->setMaxResults($params["limit"] ?? 50);
    
    $paginator = new Paginator($queryBuilder);
    
    return [
      "count" => count($paginator),
      "datas" => $paginator->getQuery()->getResult()
    ];
  }
  
  public function getById(Ulid $id): ?object {
    return parent::find($id->toBinary());
  }
  
  public function save($entity, bool $flush = false): void {
    $this->getEntityManager()->persist($entity);
    
    if($flush){
      $this->getEntityManager()->flush();
    }
  }
  
  public function remove($entity, bool $flush = false, bool $soft = true): bool {
    if($soft){
      $entity->softDelete();
    } else {
      $this->getEntityManager()->remove($entity);
    }

    if($flush){
      try {
        $this->getEntityManager()->flush();
      } catch(ORMException $ex){
        return false;
      }
    }
    
    return true;
  }
  
}