<?php

namespace App\Controller;

use App\Service\SensorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

#[Route(path: "/sensors")]
class SensorController extends AbstractController {
  
  protected SensorService $service;
  
  public function __construct(SensorService $service){
    $this->service = $service;
  }
  
  #[Route(
    path: "",
    name: "get_all_sensor",
    methods: ["GET"]
  )]
  public function getAllSensor(Request $request): JsonResponse {
    $sensor = $this->service->getAll($this->getDatasFromRequest($request)["params"]);
    
    return new JsonResponse($sensor);
  }
  
  #[Route(
    path: "",
    name: "create_sensor",
    methods: ["POST"]
  )]
  public function createSensor(Request $request): JsonResponse {
    $sensor = $this->service->save($this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($sensor);
  }
  
  #[Route(
    path: "/{id}",
    name: "update_sensor",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["PUT"]
  )]
  public function updateSensor(Request $request, Ulid $id): JsonResponse {
    $sensor = $this->service->update($id, $this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($sensor);
  }
  
  #[Route(
    path: "/{id}",
    name: "delete_sensor",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["DELETE"]
  )]
  public function deleteSensor(Ulid $id): JsonResponse {
    $this->service->delete($id);
    
    return new JsonResponse();
  }
  
}