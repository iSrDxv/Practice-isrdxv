<?php

namespace isrdxv\practice\arena\creator;

use pocketmine\utils\SingletonTrait;

use isrdxv\practice\arena\{ArenaManager, Arena};
use isrdxv\practice\arena\creator\Creator;

class CreatorManager
{
  use SingletonTrait;
  
  private array $creators;
  
  public function isCreator(string $username): bool
  {
    return isset($this->creators[$username]);
  }
  
  public function getCreator(string $username): Creator
  {
    return $this->creators[$username];
  }
  
  public function setCreator(Player $player, string $world): void
  {
    ArenaManager::getInstance()->createArena(new Arena($world));
    $this->creators[$player->getName()] = new Creator($player, ArenaManager::getInstance()->getArenaByName($world));
  }
  
  public function isCreating(string $arenaName): bool
  {
    foreach($this->creators as $username => $class) {
      if ($class->getArena()->getName() === $arenaName) {
        return true;
      }
    }
    return false;
  }
  
  public function deleteCreator(string $username): void
  {
    if (isset($this->creators[$username])) {
      unset($this->creators[$username]);
    }
  }
  
  public function cancelCreation(string $username): void
  {
    ArenaManager::getInstance()->deleteArena($this->getCreator($username)->getArena()->getName());
    $this->deleteCreator($username);
  }
  
}