<?php

namespace isrdxv\practice\queue;

use pocketmine\player\Player;
use pocketmine\event\{
  Listener,
  player\PlayerQuitEvent,
  player\PlayerDeathEvent
};

use isrdxv\practice\queue\Queue;
use isrdxv\practice\session\SessionManager;

class QueueListener implements Listener
{
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $session = SessionManager::getInstance()->get($event->getPlayer());
    if ($session->hasQueue()) {
      $session->getQueue()->removePlayer($event->getPlayer());
      $session->setQueue(null);
    }
  }
  
  public function onDeath(PlayerDeathEvent $event): void
  {
    $player = $event->getPlayer();
  }
  
}