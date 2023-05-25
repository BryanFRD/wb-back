<?php

namespace App\Controller;

use App\Service\MeasurementService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

class MeasurementController extends AbstractController {
  
  protected MeasurementService $service;
  
  public function __construct(MeasurementService $service){
    $this->service = $service;
  }
  
  #[Route(
    path: "measurements",
    name: "get_all_measurement",
    methods: ["GET"]
  )]
  public function getAllMeasurement(Request $request): JsonResponse {
    $measurements = $this->service->getAll($this->getDatasFromRequest($request)["params"]);
    
    return new JsonResponse($measurements);
  }
  
  #[Route(
    path: "measurements/{id}",
    name: "get_measurement_by_id",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["GET"]
  )]
  public function getMeasurementById(Ulid $id): JsonResponse {
    $measurement = $this->service->getAll(["id" => $id]);
    
    return new JsonResponse($measurement);
  }
  
  #[Route(
    path: "sensor/{sensorId}/measurements",
    name: "get_sensor_measurements",
    requirements: ["sensorId" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["GET"]
  )]
  public function getSensorMeasurements(Ulid $sensorId): JsonResponse {
    $measurements = $this->service->getAll(["sensorId" => $sensorId]);
    
    return new JsonResponse($measurements);
  }
  
  #[Route(
    path: "measurements",
    name: "create_measurement",
    methods: ["POST"]
  )]
  public function createMeasurement(Request $request): JsonResponse {
    $measurement = $this->service->save($this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($measurement);
  }
  
  #[Route(
    path: "measurements/{id}",
    name: "update_measurement",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["PUT"]
  )]
  public function updateMeasurement(Request $request, Ulid $id): JsonResponse {
    $measurement = $this->service->update($id, $this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($measurement);
  }
  
  #[Route(
    path: "measurements/{id}",
    name: "delete_measurement",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["DELETE"]
  )]
  public function deleteMeasurement(Ulid $id): JsonResponse {
    $this->service->delete($id);
    
    return new JsonResponse();
  }
  
}