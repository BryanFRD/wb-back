<?php

namespace App\Command;

use App\Enum\Status;
use App\Service\MeasurementService;
use App\Service\SensorService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'SimulatedMeasureCommand',
  description: 'Simulate measure for sensors marked as simulated',
)]
class SimulatedMeasureCommand extends Command {
  
  protected MeasurementService $measurementService;
  protected SensorService $sensorService;
  
  public function __construct(MeasurementService $measurementService, SensorService $sensorService){
    parent::__construct();
    $this->measurementService = $measurementService;
    $this->sensorService = $sensorService;
  }

  protected function execute(InputInterface $input, OutputInterface $output): int {
    echo "\033[01;31m Ctrl + c pour stoper la simulation \033[0m" . PHP_EOL;
    while(true){
      $simulatedSensors = $this->sensorService->getAll(["isSimulated" => true])["datas"];
      
      foreach($simulatedSensors as $sensor){
        $lastMeasure = $this->measurementService->getAll(["sensorId" => $sensor["id"], "limit" => 1]);
        $a = !empty($lastMeasure["datas"]) ? $lastMeasure["datas"][0]["measure"] : $sensor["simulationMinimum"];
        $b = $sensor["simulationMaximum"];
        $status = $sensor["status"];
        
        $m = 
          $status === Status::ACTIVE ? $this->lerp($a, $b, 0.5) : 
          ($status === Status::FAULTY ? $this->lerp($a, ($b === 0 ? 0 : $b / 2), 0.5) :
          $this->lerp($a, $sensor["simulationMinimum"], 0.5));
          
        $this->measurementService->save(["sensorId" => $sensor["id"], "measure" => round($m, 2)], false);
        
        if(rand(0, 5) === 0){
          $this->sensorService->update($sensor["id"], ["status" => Status::randomValue()]);
        }
      }
      
      $this->measurementService->flush();
      
      sleep(5);
    }
    
    return Command::SUCCESS;
  }
  
  public function lerp($a, $b, $t): float {
    return (1 - $t) * $a + $b * $t;
  }
  
}
