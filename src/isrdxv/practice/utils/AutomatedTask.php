<?php

declare(strict_types=1);

namespace isrdxv\practice\utils;

use pocketmine\scheduler\Task;
use isrdxv\practice\Loader as PracticeLoader;

abstract class AutomatedTask extends Task{

	private int $currentTick = 0;
	private int $tickPeriod;
	
	public function __construct(int $tickPeriod){
		PracticeLoader::getInstance()->getScheduler()->scheduleRepeatingTask($this, $tickPeriod);
		$this->tickPeriod = $tickPeriod;
	}

	public function onRun() : void{
		$this->onUpdate($this->tickPeriod);
		$this->currentTick += $this->tickPeriod;
	}

	abstract protected function onUpdate(int $tickDifference): void;
}