<?php

namespace App\Enum;

enum Status: string {
  
  case ACTIVE = "active";
  case FAULTY = "faulty";
  case INACTIVE = "inactive";
  
  public static function randomValue(): string {
    $arr = array_column(self::cases(), 'value');

    return $arr[array_rand($arr)];
    }
  
}