<?php

namespace App\Validator;

use Symfony\Component\Validator\Validation;

abstract class AbstractValidator {
  
  protected $validator;
  
  public function __construct(){
    $this->validator = Validation::createValidator();
  }
  
  public function validate($data, $constraints): array {
    $violations = $this->validator->validate($data, $constraints);
    
    return [
      "hasError" => count($violations) === 0,
      "violations" => $violations
    ];
  }
  
}