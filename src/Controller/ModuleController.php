<?php

namespace App\Controller;

use App\Service\ModuleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

class ModuleController extends AbstractController {
  
  protected ModuleService $service;
  
  public function __construct(ModuleService $service){
    $this->service = $service;
  }
  
  #[Route(
    path: "modules",
    name: "get_all_module",
    methods: ["GET"]
  )]
  public function getAllModule(Request $request): JsonResponse {
    $modules = $this->service->getAll($this->getDatasFromRequest($request)["params"]);
    
    return new JsonResponse($modules);
  }
  
  #[Route(
    path: "modules/{id}",
    name: "get_module_by_id",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["GET"]
  )]
  public function getModuleById(Ulid $id): JsonResponse {
    $module = $this->service->getAll(["id" => $id]);
    
    return new JsonResponse($module);
  }
  
  #[Route(
    path: "modules",
    name: "create_module",
    methods: ["POST"]
  )]
  public function createModule(Request $request): JsonResponse {
    $modules = $this->service->save($this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($modules);
  }
  
  #[Route(
    path: "modules/{id}",
    name: "update_module",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["PUT"]
  )]
  public function updateModule(Request $request, Ulid $id): JsonResponse {
    $modules = $this->service->update($id, $this->getDatasFromRequest($request)["body"]);
    
    return new JsonResponse($modules);
  }
  
  #[Route(
    path: "modules/{id}",
    name: "delete_module",
    requirements: ["id" => "[0-7][0-9A-HJKMNP-TV-Z]{25}"],
    methods: ["DELETE"]
  )]
  public function deleteModule(Ulid $id): JsonResponse {
    $this->service->delete($id);
    
    return new JsonResponse();
  }
  
}