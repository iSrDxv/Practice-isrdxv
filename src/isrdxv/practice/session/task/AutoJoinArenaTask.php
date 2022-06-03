<?php

namespace isrdxv\practice\session\task;

use isrdxv\practice\session\Session;

class AutoJoinArenaTask extends Task
{
  private Session $session;
  
  public function __construct(Session $session)
  {
    $this->session = $session;
  }
  
  public function onRun(): void
  {
    $player = $this->session->getPlayer();
    if (!$player->isOnline()) {
      $this->getHandler()->cancel();
      return;
    }
  }
  
}