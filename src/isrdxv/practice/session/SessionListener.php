<?php

namespace isrdxv\practice\session;

use pocketmine\event\{
  Listener,
  player\PlayerLoginEvent,
  player\PlayerJoinEvent,
  player\PlayerRespawnEvent,
  player\PlayerInteractEvent,
  player\PlayerQuitEvent,
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
    $query = $player->getServer()->getQueryInformation();
    $player->getServer()->getConfigGroup()->setConfigInt("max-players", $query->getPlayerCount() + 1);
    if (!$player->hasPlayedBefore()) {
      SessionManager::getInstance()->set($player->getName());
    }
    SessionManager::getInstance()->create($player);
  }
  
  public function onJoin(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    var_dump($player->getPlayerInfo()->getExtraData());
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
    $world = Server::getInstance()->getWorldManager()->getWorldByName(Loader::getInstance()->getConfig()->get("lobby-name"));
    $player->teleport($world->getSafeSpawn());
    $session->giveLobbyItems();
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    Loader::getInstance()->getProvider()->saveDataSession($player->getName(), (SessionManager::getInstance()->get($player->getName()))->__toArray());
    $event->setQuitMessage(Loader::getInstance()->getTranslation()->sendTranslation(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "leave-message", ["username" => $player->getName()]));
  }
  
  /**
   * @priority LOW
   */
  public function onQuery(QueryRegenerateEvent $event): void
  {
    $query = $event->getQueryInfo();
    $query->setServerName(Loader::getInstance()->getConfig()->get("server-name"));
    if ($query->canListPlugins() === false) {
      $query->setListPlugins(true);
      $query->setPlugins([Loader::getInstance()]);
    }
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
    if ($item->getCustomName() === TextFormat::colorize("&l&fSettings")) {
      $player->sendForm(FormManager::getInstance()->settings(SessionManager::getInstance()->get($player->getName())));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fParty")) {
      $player->sendForm(FormManager::getInstance()->party(SessionManager::getInstance()->get($player->getName())));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fRanked &cQueue")) {
      $player->sendForm(FormManager::getInstance()->ranked(SessionManager::getInstance()->get($player->getName())));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fUnRanked &cQueue")) {
      $player->sendForm(FormManager::getInstance()->unranked(SessionManager::getInstance()->get($player->getName())));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fFFA &cQueue")) {
      $player->sendForm(FormManager::getInstance()->ffa(SessionManager::getInstance()->get($player->getName())));
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
        }
      }
    }
  }
  
}