<?php

namespace isrdxv\practice;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\ClosureTask;

// libasynql (PMMP)
use poggit\libasynql\libasynql;

use isrdxv\practice\translation\Translation;
use isrdxv\practice\provider\YAMLProvider;
use isrdxv\practice\arena\ArenaManager;
use isrdxv\practice\game\{
  GameManager,
  GameListener,
  GameTask
};
use isrdxv\practice\queue\{
  QueueManager,
  QueueListener
};
use isrdxv\practice\session\{
  SessionListener,
  SessionManager
};
use isrdxv\practice\command\{
  ArenaCommand,
  HubCommand,
  BanCommand
};
use isrdxv\practice\kit\KitManager;
use isrdxv\practice\webhook\WebhookManager;

class Loader extends PluginBase
{
  private $database;
  
  private Translation $translation;
  
  private YAMLProvider $provider;
  
  private ArenaManager $arenaManager;
  
  private GameManager $gameManager;
  
  private QueueManager $queueManager;
  
  private WebhookManager $webhook;
  
  protected static $instance;
  
  public function onLoad(): void
  {
    self::$instance = $this;
    $this->saveDefaultConfig();
    $lobby = $this->getConfig()->get("lobby-name");
    $this->getServer()->getWorldManager()->loadWorld($lobby);
    $this->getServer()->getWorldManager()->setDefaultWorld($this->getServer()->getWorldManager()->getWorldByName($lobby));
    $this->getServer()->getConfigGroup()->setConfigString("motd", TextFormat::colorize($this->getConfig()->get("server-name")));
    $this->saveResource("arenas/world.yml");
  }
  
  public function onEnable(): void
  {
    KitManager::getInstance()->init();
    $this->arenaManager = new ArenaManager($this);
    $this->gameManager = new GameManager($this);
    $this->queueManager = new QueueManager();
    foreach(["languages/es_ES.ini", "languages/en_US.ini"] as $language) {
      $this->saveResource($language);
    }
    $this->translation = new Translation();
    $this->provider = new YAMLProvider();
    /*$this->webhook = new WebhookManager($this);
    $this->webhook->sendStatus();*/
    
    /* Code of libasynql */
    $this->database = libasynql::create($this, $this->getConfig()->get("database"), [
            /*"sqlite" => "sqlite.sql",*/
            "mysql" => "mysql.sql"
    ]);
    
    $this->getServer()->getPluginManager()->registerEvents(new SessionListener(), $this);
    $this->getServer()->getPluginManager()->registerEvents(new GameListener(), $this);
    $this->getServer()->getPluginManager()->registerEvents(new QueueListener(), $this);
    $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
      foreach(SessionManager::getInstance()->getSessions() as $session) {
        $session->changeScoreboard();
      }
    }), 25);
    $this->getScheduler()->scheduleRepeatingTask(new GameTask($this), 30);
    foreach(["ban", "kick", "me", "plugins", "pardon", "pardon-ip", "tell", "about", "list", "kill"] as $command) {
      $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand($command));
    }
    $this->getServer()->getCommandMap()->registerAll("practice", [
      new ArenaCommand(),
      new HubCommand(),
      new BanCommand()
    ]);
    $this->getServer()->getNetwork()->setName(TextFormat::colorize($this->getConfig()->get("motd")));
    $this->getLogger()->info("Plugin enabled!!");
  }
  
  protected function onDisable(): void
  {
    if(isset($this->database)) {  $this->database->close(); }
    //$this->webhook->sendStatus(false);
  }
  
  public function getTranslation(): Translation
  {
    return $this->translation;
  }
  
  public function getProvider(): YAMLProvider
  {
    return $this->provider;
  }
  
  public function getArenaManager(): ArenaManager
  {
    return $this->arenaManager;
  }
  
  public function getGameManager(): GameManager
  {
    return $this->gameManager;
  }
  
  public function getQueueManager(): QueueManager
  {
    return $this->queueManager;
  }
  
  public function getWebhookManager(): WebhookManager
  {
    return $this->webhook;
  }
  
  public static function getInstance(): Loader
  {
    return self::$instance;
  }
  
}
