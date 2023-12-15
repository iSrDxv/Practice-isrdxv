<?php

declare(strict_types=1);

namespace isrdxv\practice\hologram\task;

use isrdxv\practice\hologram\HologramManager;
use isrdxv\practice\utils\{
  Time,
  AutomatedTask
};

class UpdateHologramTask extends AutomatedTask{

	public function __construct(){
		parent::__construct(Time::secondsToTicks(10));
	}

	public function onUpdate(): void{
		HologramManager::getInstance()->updateHolograms();
	}
	
}