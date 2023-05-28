<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\Request;

class AbstractController extends SymfonyAbstractController {
  
  public function getDatasFromRequest(Request $request) {
    $body = json_decode($request->getContent(), true) ?? [];
    $params = $request->query->all();
    
    return [
      "params" => $params,
      "body" => $body
    ];
  }
  
}