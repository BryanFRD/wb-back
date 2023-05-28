<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\Sensor;
use App\Enum\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ModuleFixtures extends Fixture
{
    
  public function load(ObjectManager $manager): void {
    $faker = Faker::create("fr_FR");
    
    for($i = 0; $i < 10; $i++){
      $module = new Module();
      $module
        ->setName("Module - " . $faker->unique()->word())
        ->setStatus($faker->randomElement(Status::cases()))
        ->updateTimestamps();
      
      for($j = 0; $j < 5; $j++){
        $sensor = new Sensor();
        $type = $faker->randomElement(["Vitesse", "Temperature", "Energie"]);
        $sensor
          ->setName("Sensor #$j - " . $type)
          ->setStatus($faker->randomElement(Status::cases()))
          ->setMeasurementType($type)
          ->setSimulationMinimum($faker->randomDigit())
          ->setSimulationMaximum($faker->randomNumber(2))
          ->setModule($module)
          ->updateTimestamps();
        
        $manager->persist($sensor);
      }
          
      $manager->persist($module);
    }

    $manager->flush();
  }
    
}
