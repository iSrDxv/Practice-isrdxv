<?php

namespace isrdxv\practice\arena\event;

use pocketmine\event\Event;

use isrdxv\practice\arena\Arena;

abstract class ArenaEvent extends Event {
  
  /** @var Arena **/
  private Arena $arena;
  
  public function __construct(Arena $arena)
  {
    $this->arena = $arena;
  }
  
  public function getArena(): Arena
  {
    return $this->arena;
  }
  
}