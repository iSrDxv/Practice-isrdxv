<?php

namespace isrdxv\practice\provider;

use isrdxv\practice\Loader;
use isrdxv\practice\session\Session;

use pocketmine\utils\Config;
use pocketmine\network\mcpe\protocol\types\DeviceOS;

class YAMLProvider
{
  
  public function __construct()
  {
    if (!is_dir($dir = Loader::getInstance()->getDataFolder() . "arenas" . DIRECTORY_SEPARATOR)) {
      @mkdir($dir);
    }
    if (!is_dir($folder = Loader::getInstance()->getDataFolder() . "kits" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
    if (!is_dir($folder = Loader::getInstance()->getDataFolder() . "backup" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
  }
  
  public function saveDataSession(Session $session): void 
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $session->getPlayer()->getName() . ".yml", Config::YAML);
    foreach($session->__toArray() as $key => $value) {
      $config->set($key, $value);
    }
    $config->save();
  }
  
  public function getDevice(array $extraData): string
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
      DeviceOS::GEAR_VR => "GearVR",
      DeviceOS::HOLOLENS => "Hololens",
      DeviceOS::WINDOWS_10 => "Windows 10",
      DeviceOS::WIN32 => "Windows 7",
      DeviceOS::DEDICATED => "Dedicated",
      DeviceOS::TVOS => "tvOS",
      DeviceOS::PLAYSTATION => "PlayStation",
      DeviceOS::NINTENDO => "Nintendo Switch",
      DeviceOS::XBOX => "Xbox",
      DeviceOS::WINDOWS_PHONE => "Windows Phone",
      default => "Unknown"
    };
  }
  
  public function getDeviceControl(array $extraData): string
  {
    if ($extraData["DeviceOS"] === DeviceOS::ANDROID && $extraData["DeviceModel"] === "") {
      return "Keyboard";
    }

    return match ($extraData["DeviceOS"])
    {
      DeviceOS::UNKNOWN => "Unknown",
      DeviceOS::ANDROID => "Touch",
      DeviceOS::IOS => "Touch",
      DeviceOS::OSX => "Keyboard",
      DeviceOS::AMAZON => "Touch",
      DeviceOS::GEAR_VR => "Controller",
      DeviceOS::HOLOLENS => "Controller",
      DeviceOS::WINDOWS_10 => "Keyboard",
      DeviceOS::WIN32 => "Keyboard",
      DeviceOS::DEDICATED => "Dedicated",
      DeviceOS::TVOS => "Controller",
      DeviceOS::PLAYSTATION => "Joystick",
      DeviceOS::NINTENDO => "Joystick",
      DeviceOS::XBOX => "Joystick",
      DeviceOS::WINDOWS_PHONE => "Touch",
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
    return (new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML))->getNested("settings") ?? [];
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