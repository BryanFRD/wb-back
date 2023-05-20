<?php

namespace App\Enum;

enum Status: string {
  
  case ACTIVE = "active";
  case FAULTY = "faulty";
  case INACTIVE = "inactive";
  
}