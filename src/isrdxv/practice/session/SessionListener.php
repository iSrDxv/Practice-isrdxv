<?php

namespace isrdxv\practice\session;

use pocketmine\event\{
  Listener,
  player\PlayerLoginEvent,
  player\PlayerJoinEvent,
  player\PlayerRespawnEvent,
  player\PlayerInteractEvent,
  player\PlayerQuitEvent,
  player\PlayerDropItemEvent,
  server\QueryRegenerateEvent,
  block\BlockBreakEvent,
  block\BlockPlaceEvent,
  entity\EntityDamageEvent,
  entity\EntityDamageByEntityEvent
};
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;
use pocketmine\Server;

use isrdxv\practice\Loader;
use isrdxv\practice\session\SessionManager;
use isrdxv\practice\form\FormManager;

class SessionListener implements Listener
{
  
  /**
   * @priority HIGH
   */
  public function onLogin(PlayerLoginEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player->hasPlayedBefore()) {
      SessionManager::getInstance()->set($player->getName());
    }
    SessionManager::getInstance()->create($player);
  }
  
  public function onJoin(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    $session = SessionManager::getInstance()->get($player->getName());
    $world = Server::getInstance()->getWorldManager()->getWorldByName(Loader::getInstance()->getConfig()->get("lobby-name"));
    
    $player->teleport($world->getSafeSpawn());
    $session->giveLobbyItems();
    
    if (is_array($desc = Loader::getInstance()->getConfig()->get("server-description"))) {
      $text = implode("\n", $desc);
      $player->sendMessage(TextFormat::colorize($text));
    }
    if (is_string($desc = Loader::getInstance()->getConfig()->get("server-description"))) {
      $player->sendMessage(TextFormat::colorize($desc));
    }
    
    $event->setJoinMessage(TextFormat::colorize(Loader::getInstance()->getTranslation()->sendTranslation(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "welcome-message", ["username" => $player->getName()])));
  }
  
  public function onRespawn(PlayerRespawnEvent $event): void
  {
    $player = $event->getPlayer();
    $session = SessionManager::getInstance()->get($player->getName());
    $session->teleportToLobby();
    $session->giveLobbyItems();
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    $session = SessionManager::getInstance()->get($player->getName());
    Loader::getInstance()->getProvider()->saveDataSession($session);
    $event->setQuitMessage(TextFormat::colorize(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "leave-message", ["username" => $player->getName()])));
  }
  
  /**
   * @priority LOW
   */
  public function onQuery(QueryRegenerateEvent $event): void
  {
    $query = $event->getQueryInfo();
    $query->setServerName(TextFormat::colorize(Loader::getInstance()->getConfig()->get("server-name")));
    $query->setListPlugins(true);
    $query->setPlugins([Loader::getInstance()]);
    $query->setWorld(Loader::getInstance()->getConfig()->get("lobby-name"));
    //$query->setMaxPlayerCount($query->getPlayerCount() + 1);
  }
  
  /**
   * @priority HIGHEST
   */
  public function onInteract(PlayerInteractEvent $event): void
  {
    $player = $event->getPlayer();
    $item = $event->getItem();
    $session = SessionManager::getInstance()->get($player->getName());
    if ($item->getCustomName() === TextFormat::colorize("&l&fSettings")) {
      $player->sendForm(FormManager::getInstance()->settings($session));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fParty")) {
      $player->sendForm(FormManager::getInstance()->party($session));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fRanked &cQueue")) {
      $player->sendForm(FormManager::getInstance()->ranked($session));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fUnRanked &cQueue")) {
      $player->sendForm(FormManager::getInstance()->unranked($session));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fFFA &cQueue")) {
      $player->sendForm(FormManager::getInstance()->ffa($session));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&o&fLeave Queue")) {
      if ($session->hasQueue()) {
        $session->getQueue()->deletePlayer($session);
        $session->setQueue();
        $session->giveLobbyItems();
      }
    }
  }
  
  public function onBreak(BlockBreakEvent $event): void
  {
    $player = $event->getPlayer();
    if ($player->getWorld()->getFolderName() === Loader::getInstance()->getConfig()->get("lobby-name")) {
      if (Server::getInstance()->isOp($player->getName()) || $player->hasPermission("lobby.block.break")) {
          $event->uncancel();
      }
    }
    $event->cancel();
  }

  public function onPlace(BlockPlaceEvent $event): void
  {
    $player = $event->getPlayer();
    if ($player->getWorld()->getFolderName() === Loader::getInstance()->getConfig()->get("lobby-name")) {
      if (Server::getInstance()->isOp($player->getName()) || $player->hasPermission("lobby.block.place")) {
          $event->uncancel();
      }
    }
    $event->cancel();
  }
  
  public function onDamage(EntityDamageEvent $event): void
  {
    $entity = $event->getEntity();
    if ($event instanceof EntityDamageByEntityEvent) {
      $damager = $event->getDamager();
      if ($damager->getWorld()->getFolderName() === Loader::getInstance()->getConfig()->get("lobby-name")) {
        if ($entity instanceof Player && $damager instanceof Player) {
          $event->cancel();
        }elseif ($event->getCause() === EntityDamageEvent::CAUSE_FALL) {
          $event->cancel();
        }
      }
    }
  }
  
  public function onDrop(PlayerDropItemEvent $event): void
  {
    $player = $event->getPlayer();
    if ($player->getWorld()->getFolderName() === Loader::getInstance()->getConfig()->get("lobby-name")) {
      $event->cancel();
    }
  }
  
}
