<?php

namespace isrdxv\practice\session;

use pocketmine\event\{
  Listener,
  player\PlayerLoginEvent,
  player\PlayerJoinEvent,
  player\PlayerRespawnEvent,
  player\PlayerInteractEvent,
  player\PlayerQuitEvent,
  server\QueryRegenerateEvent
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
  public function preLogin(PlayerLoginEvent $event): void
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
    
    $event->setJoinMessage(TextFormat::colorize(Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "welcome-message", ["%username%" => $player->getName()])));
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    Loader::getInstance()->getProvider()->saveDataSession($player->getName(), (SessionManager::getInstance()->get($player->getName()))->__toArray());
    //$event->setQuitMessage();
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
    $query->setMaxPlayerCount($query->getPlayerCount() + 1);
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
      $player->sendForm(FormManager::getInstance()->party($player));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fRanked &cQueue")) {
      $player->sendForm(FormManager::getInstance()->ranked($player));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fUnRanked &cQueue")) {
      $player->sendForm(FormManager::getInstance()->unranked($player));
    }elseif ($item->getCustomName() === TextFormat::colorize("&l&fFFA &cQueue")) {
      $player->sendForm(FormManager::getInstance()->ffa($player));
    }
  }
  
}
