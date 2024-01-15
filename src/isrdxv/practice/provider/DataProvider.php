<?php

namespace isrdxv\practice\provider;

use isrdxv\practice\Loader;
use isrdxv\practice\session\Session;

use pocketmine\utils\Config;
use pocketmine\network\mcpe\protocol\types\DeviceOS;

class DataProvider
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
  
  public function getDefaultLanguage(): string
  {
    return Loader::getInstance()->getConfig()->getNested("default-language");
  }
  
}