<?php

namespace App\Validator;

use Symfony\Component\Validator\Validation;

abstract class AbstractValidator {
  
  protected $validator;
  
  public function __construct(){
    $this->validator = Validation::createValidator();
  }
  
  public abstract function validate($data): array;
  
}