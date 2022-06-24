<?php

namespace isrdxv\practice\game;

use isrdxv\practice\Loader;

class GameTask extends Task
{
  /** @var Loader **/
  private $loader;
  
  public function __construct(Loader $loader)
  {
    $this->loader = $loader;
  }
  
  public function onRun(): void
  {
    foreach($this->loader->getGameManager()->getGames() as $game) {
      if ($game->getPhase() === $this->loader->getGameManager()::PHASE_WAITING) {
        if ($game->getPlayerCount() === 2) {
          $game->setPhase($this->loader->getGameManager()::PHASE_STARTING);
        }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_STARTING) {
          $game->toReset();
        }
      }
    }
  }
  
}