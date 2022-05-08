<?php

namespace isrdxv\practice\provider;

use isrdxv\practice\Loader;

use pocketmine\utils\Config;

class YAMLProvider
{
  
  public function __construct()
  {
    if (!is_dir($dir = Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR)) {
      @mkdir($dir);
    }
    if (!is_dir($dir = Loader::getInstance()->getDataFolder() . "arenas" . DIRECTORY_SEPARATOR)) {
      @mkdir($dir);
    }
  }
  
  //public function savePlayer(): void {}
  
  public function setLanguage(string $username, string $language): void
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    $config->setNested("language", $language);
    $config->save();
  }
  
  public function loadSettings(string $username): array
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML))->getNested("settings");
  }
  
  public function saveSettings(string $username, array $settings = []): void
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    if (!$config->exists("settings")) { 
      $config->set("settings", []);
      $config->save();
      return;
    }
    $config->setNested("settings", $settings);
    $config->save();
  }
  
  public function loadWonEvents(string $username): array
  {
    return (new Config(Loader::getInstance()->getDatFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML))->getNested("won-events");
  }
  
  public function saveWonEvents(string $username, array $events = []): void
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    if (!$config->exists("won-events")) {
      $config->set("won-events", $events);
      $config->save();
      return;
    }
    $config->setNested("won-events", $events);
    $config->save();
  }
  
  /*public function isPartner(string $username): bool
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    if ($config->get("associate") !== false or $config->exists("associate")) {
      return true;
    }
    return false;
  }*/
  
}
