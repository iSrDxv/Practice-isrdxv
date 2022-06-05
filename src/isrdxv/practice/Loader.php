<?php

namespace isrdxv\practice;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\ClosureTask;

use libs\invmenu\InvMenuHandler;

use isrdxv\practice\translation\Translation;
use isrdxv\practice\provider\YAMLProvider;
use isrdxv\practice\arena\ArenaManager;
use isrdxv\practice\session\{
  SessionListener,
  SessionManager
};
use isrdxv\practice\command\{
  PracticeCommand,
  HubCommand
};
use isrdxv\practice\kit\KitManager;

class Loader extends PluginBase
{
  public const PREFIX_PRACTICE = "&l&0[&3Practice&0] ";
  
  private Translation $translation;
  
  private YAMLProvider $provider;
  
  protected static $instance;
  
  public function onLoad(): void
  {
    self::$instance = $this;
    $this->saveDefaultConfig();
    $this->getServer()->getConfigGroup()->setConfigString("motd", $this->getConfig()->get("server-name"));
    /*
    foreach(glob($this->getDataFolder() . "players" . DIRECTORY_SEPARATOR . "*.yml") as $player) {
      $player = new Config($player, Config::YAML);
      SessionManager::getInstance()->setSession($player->get("name"), ?);
    }
    */
  }
  
  public function onEnable(): void
  {
    if (!InvMenuHandler::isRegistered()) {
      InvMenuHandler::register($this);
    }
    ArenaManager::getInstance()->loadArenas();
    GameManager::getInstance()->loadGames();
    //KitManager::getInstance()->init();
    foreach(["languages/es_ES.ini", "languages/en_US.ini"] as $language) {
      $this->saveResource($language);
    }
    $this->translation = new Translation();
    $this->provider = new YAMLProvider();
    $this->getServer()->getPluginManager()->registerEvents(new SessionListener(), $this);
    //$this->getServer()->getPluginManager()->registerEvents(new GameListener(), $this);
    //$this->getServer()->getPluginManager()->registerEvents(new QueueListener(), $this);
    $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
      foreach(SessionManager::getInstance()->getSessions() as $session) {
        $session->changeScoreboard();
      }
    }), 20);
    foreach(["ban", "kick", "me", "plugins", "pardon", "pardon-ip", "tell", "about", "list"] as $command) {
      $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand($command));
    }
    $this->getServer()->getCommandMap()->registerAll("practice", [
      new PracticeCommand(),
      new HubCommand()
    ]);
    $this->getServer()->getNetwork()->setName(TextFormat::colorize($this->getConfig()->get("motd")));
    $lobby = $this->getConfig()->get("lobby-name");
    $this->getServer()->getWorldManager()->loadWorld($lobby);
    $this->getServer()->getWorldManager()->setDefaultWorld($this->getServer()->getWorldManager()->getWorldByName($lobby));
    $this->getLogger()->info("Plugin enabled!!");
  }
  
  public function getTranslation(): Translation
  {
    return $this->translation;
  }
  
  public function getProvider(): YAMLProvider
  {
    return $this->provider;
  }
  
  public static function getInstance(): Loader
  {
    return self::$instance;
  }
  
}
