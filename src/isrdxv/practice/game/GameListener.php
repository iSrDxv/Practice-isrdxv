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
      if ($game->getWorld()->getDisplayName() === $entity->getWorld()->getDisplayName()) {
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
        //TODO: This would cause problems later, but I will fix it soon jsjsjs
        //NOTE: I shouldn't change the knockback globally, it should be for mundox but situations happened and I didn't think it through
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
