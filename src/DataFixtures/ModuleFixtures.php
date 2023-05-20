<?php

namespace App\DataFixtures;

use App\Entity\Module;
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
          
      $manager->persist($module);
    }

    $manager->flush();
  }
    
}
