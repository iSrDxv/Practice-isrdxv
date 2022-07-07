<?php

namespace isrdxv\practice\game;

use pocketmine\event\{
  Listener,
  player\PlayerDeathEvent,
  player\PlayerQuitEvent
};
use pocketmine\player\Player;

use isrdxv\practice\game\GameManager;
use isrdxv\practice\session\SessionManager;

class GameListener implements Listener
{
  
  public function onDeath(PlayerDeathEvent $event): void
  {
    $event->setDrops([]);
    $loser = SessionManager::getInstance()->get($event->getPlayer());
    if (!($loser->isPlaying())) {
      return;
    }
    $game = $loser->getGame();
    if ($game->getPhase() !== GameManager::PHASE_PLAYING) {
      return;
    }
    $game->finish($loser);
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $session = SessionManager::getInstance()->get($event->getPlayer());
    if ($session->isGame()) {
      $session->getGame()->finish($session);
    }
  }
  
}