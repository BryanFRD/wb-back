<?php

namespace App\Doctrine\Type;

use App\Enum\Status;

class StatusEnumType extends EnumType {
  
  protected $name = "status_enum";
  protected $enum = Status::class;
  
}