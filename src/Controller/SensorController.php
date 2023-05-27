<?php

namespace App\Controller;

use App\Service\SensorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

class SensorController extends AbstractController {
  
  protected SensorService $service;
  
  public function __construct(SensorService $service){
    $this->service = $service;
  }
  
  #[Route(
    path: "sensors",
    name: "get_all_sensor",
    methods: ["GET"]
  )]
  public function getAllSensor(Request $request): JsonResponse {
    $sensors = $this->service->getAll($this->getDatasFromRequest($request)["params"]);
    
    return new JsonResponse($sensors);
  }
  
  #[Route(
    path: "sensors/{id}",
    name: "get_sensor_by_id",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["GET"]
  )]
  public function getMeasurementById(Ulid $id): JsonResponse {
    $sensor = $this->service->getById($id);
    
    return new JsonResponse($sensor);
  }
  
  #[Route(
    path: "modules/{moduleId}/sensors",
    name: "get_module_sensor",
    requirements: ["moduleId" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["GET"]
  )]
  public function getModuleSensors(Ulid $moduleId): JsonResponse {
    $sensors = $this->service->getAll(["moduleId" => $moduleId]);
    
    return new JsonResponse($sensors);
  }
  
  #[Route(
    path: "sensors",
    name: "create_sensor",
    methods: ["POST"]
  )]
  public function createSensor(Request $request): JsonResponse {
    $sensor = $this->service->save($this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($sensor);
  }
  
  #[Route(
    path: "sensors/{id}",
    name: "update_sensor",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["PUT"]
  )]
  public function updateSensor(Request $request, Ulid $id): JsonResponse {
    $sensor = $this->service->update($id, $this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($sensor);
  }
  
  #[Route(
    path: "sensors/{id}",
    name: "delete_sensor",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["DELETE"]
  )]
  public function deleteSensor(Request $request, Ulid $id): JsonResponse {
    $params = $this->getDatasFromRequest($request)["params"];
    $this->service->delete($id, true, $params["soft"] ?? true);
    
    return new JsonResponse();
  }
  
}