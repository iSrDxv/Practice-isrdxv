<?php

namespace isrdxv\practice\provider;

use isrdxv\practice\Loader;

use pocketmine\utils\Config;
use pocketmine\network\mcpe\protocol\types\DeviceOS;

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
    if (!is_dir($folder = Loader::getInstance()->getDataFolder() . "bans" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
  }
  
  public function saveDataSession(string $name, array $data): void 
  {
    if (empty($data) || empty($name)) return;
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML);
    $config->setAll($data);
    $config->save();
  }
  
  public function getPlatform(array $extraData): string
  {
    if ($extraData["DeviceOS"] === DeviceOS::ANDROID && $extraData["DeviceModel"] === "") {
      return "Linux";
    }

    return match ($extraData["DeviceOS"])
    {
      DeviceOS::UNKNOWN => "Unknown",
      DeviceOS::ANDROID => "Android",
      DeviceOS::IOS => "iOS",
      DeviceOS::OSX => "macOS",
      DeviceOS::AMAZON => "FireOS",
      DeviceOS::GEAR_VR => "Gear VR",
      DeviceOS::HOLOLENS => "Hololens",
      DeviceOS::WINDOWS_10 => "Windows 10",
      DeviceOS::WIN32 => "Windows 7",
      DeviceOS::DEDICATED => "Dedicated",
      DeviceOS::TVOS => "TV OS",
      DeviceOS::PLAYSTATION => "PlayStation",
      DeviceOS::NINTENDO => "Nintendo Switch",
      DeviceOS::XBOX => "Xbox",
      DeviceOS::WINDOWS_PHONE => "Windows Phone",
      default => "Unknown"
    };
  }
  
  public function getDeviceMode(): string
  {
    return "SM-67688SD";
  }
  
  public function setLanguage(string $username, string $language = "en_US"): void
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    $config->setNested("language", $language);
    $config->save();
  }
  
  public function getLanguage(string $username): string
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML))->get("language");
  }
  
  public function getDefaultLanguage(): string
  {
    return Loader::getInstance()->getConfig()->getNested("default-language");
  }
  
  public function loadSettings(string $username): array
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML))->getNested("settings");
  }
  
  public function saveSettings(string $username, array $settings = []): void
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    if (!$config->exists("settings")) { 
      $config->set("settings", ["score" => true, "queue" => false, "cps" => false, "auto-join" => false]);
      $config->save();
      return;
    }
    $config->setNested("settings", $settings);
    $config->save();
  }
  
  public function loadWonEvents(string $username): array
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML))->getNested("won-events");
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
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML))->getNested("murders");
  }
  
  public function loadDeaths(string $name): array
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML))->getNested("deaths");
  }
  
  public function loadPoints(string $name): int
  {
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $name . ".yml", Config::YAML))->getNested("points");
  }
  
}