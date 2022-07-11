<?php

namespace isrdxv\practice\kit;

use isrdxv\practice\kit\Kit;
use isrdxv\practice\kit\type\{
  NoDebuff,
  Gapple,
  Combo
};

use pocketmine\utils\SingletonTrait;

class KitManager
{
  use SingletonTrait;
  
  private array $kits;
  
  public function init(): void
  {
    $this->registerAll([
      new NoDebuff(),
      new Gapple(),
      //new BuildUHC(),
      new Combo(),
      //new Archer(),
      //new Trapping()
    ]);
  }
  
  public function register(?Kit $kit): void
  {
    if (empty($kit)) {
      return;
    }
    $this->kits[$kit->getName()] = $kit;
  }
  
  public function registerAll(?array $kits): void
  {
    if (empty($kits)) {
      return;
    }
    foreach($kits as $kit) {
      $this->register($kit);
    }
  }
  
  public function getKitByName(string $kitName): ?Kit
  {
    if (empty($kitName)) {
      return null;
    }
    foreach($this->kits as $name => $class) {
      if ($name === $kitName) {
        return $class;
      }
    }
    return null;
  }
  
}
