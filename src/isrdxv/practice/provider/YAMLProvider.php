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
    if (!is_dir($folder = Loader::getInstance()->getDataFolder() . "kits" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
  }
  
  public function saveDataSession(string $name, array $data): void 
  {
    if ($data === [] || $name === "") return;
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML);
    $config->setAll($data);
    $config->save();
  }
  
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
  
  public function loadMurders(string $name): array
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML))->get("murders");
  }
  
  public function loadDeaths(string $name): array
  {
    (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML))->get("deaths");
  }
  
  public function loadPoints(string $name): int
  {
    (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML))->get("points");
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
