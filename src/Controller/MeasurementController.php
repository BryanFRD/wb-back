<?php

namespace App\Controller;

use App\Service\MeasurementService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

#[Route(path: "/measurements")]
class MeasurementController extends AbstractController {
  
  protected MeasurementService $service;
  
  public function __construct(MeasurementService $service){
    $this->service = $service;
  }
  
  #[Route(
    path: "",
    name: "get_all_measurement",
    methods: ["GET"]
  )]
  public function getAllMeasurement(Request $request): JsonResponse {
    $measurement = $this->service->getAll($this->getDatasFromRequest($request)["params"]);
    
    return new JsonResponse($measurement);
  }
  
  #[Route(
    path: "",
    name: "create_measurement",
    methods: ["POST"]
  )]
  public function createMeasurement(Request $request): JsonResponse {
    $measurement = $this->service->save($this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($measurement);
  }
  
  #[Route(
    path: "/{id}",
    name: "update_measurement",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["PUT"]
  )]
  public function updateMeasurement(Request $request, Ulid $id): JsonResponse {
    $measurement = $this->service->update($id, $this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($measurement);
  }
  
  #[Route(
    path: "/{id}",
    name: "delete_measurement",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["DELETE"]
  )]
  public function deleteMeasurement(Ulid $id): JsonResponse {
    $this->service->delete($id);
    
    return new JsonResponse();
  }
  
}