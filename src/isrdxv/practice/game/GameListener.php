<?php

namespace isrdxv\practice\game;

use pocketmine\event\{
  Listener,
  player\PlayerDeathEvent,
  player\PlayerQuitEvent,
  entity\EntityDamageEvent,
  entity\EntityDamageByEntityEvent
};
use pocketmine\player\Player;

use isrdxv\practice\arena\mode\ModeType;
use isrdxv\practice\game\GameManager;
use isrdxv\practice\session\SessionManager;
use isrdxv\practice\Loader;
  
class GameListener implements Listener
{
  
  public function onDeath(PlayerDeathEvent $event): void
  {
    $event->setDrops([]);
    $loser = SessionManager::getInstance()->get($event->getPlayer()->getName());
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
    $session = SessionManager::getInstance()->get($event->getPlayer()->getName());
    if ($session->isGame()) {
      $session->getGame()->finish($session);
    }
  }
  
  public function onDamage(EntityDamageEvent $event): void
  {
    $entity = $event->getEntity();
    if (!$entity instanceof Player) {
      return;
    }
    foreach(Loader::getInstance()->getGameManager()->getGames() as $game) {
      if (Server::getInstance()->getWorldManager()->getWorldByName($game->getArena()->getName())->getFolderName() === $entity->getWorld()->getFolderName()) {
        if ($event->getCause() === EntityDamageEvent::CAUSE_SUFFOCATION && $event->getCause() === CAUSE_FALL) {
          $event->cancel();
        }
      }
    }
  }
  
  public function onKnockback(EntityDamageEvent $event): void
  {
    $entity = $event->getEntity();
    if (!$entity instanceof Player) {
      return;
    }
    if ($event instanceof EntityDamageByEntityEvent) {
      $damager = $event->getDamager();
      foreach(Loader::getInstance()->getGameManager()->getGames() as $game) {
        if ($game->getArenaMode() === ModeType::COMBO) {
          $event->setKnockBack(Loader::getInstance()->getConfig()->get("knockback")["combo"]);
        }
        if ($game->getArenaMode() === ModeType::NO_DEBUFF) {
          $event->setKnockBack(Loader::getInstance()->getConfig()->get("knockback")["nodebuff"]);
        }
        if ($game->getArenaMode() === ModeType::GAPPLE) {
          $event->setKnockBack(Loader::getInstance()->getConfig()->get("knockback")["gapple"]);
        }
        $event->setAttackCooldown(Loader::getInstance()->getConfig()->get("cooldown-attack"));
      }
    }
  }
  
}
