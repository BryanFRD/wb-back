<?php

namespace App\Doctrine\Type;

use App\Enum\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

abstract class EnumType extends Type {
  
  protected $name;
  protected $enum;
  
  public function getSQLDeclaration(array $column, AbstractPlatform $platform){
    $values = implode("', '", array_map(function($val) {return $val->value;}, Status::cases()));
    return "ENUM('$values')";
  }
  
  public function convertToPHPValue($value, AbstractPlatform $platform){
    return $value;
  }
  
  public function convertToDatabaseValue($value, AbstractPlatform $platform){
    if(Status::tryFrom($value) === null){
      throw new InvalidArgumentException("Invalid value '$this->name'.");
    }
    
    return $value;
  }
  
  public function getName(){    
    return $this->name;
  }
  
  public function requiresSQLCommentHint(AbstractPlatform $platform){
    return true;
  }
  
}