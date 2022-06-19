<?php

namespace isrdxv\practice\arena\creator;

use pocketmine\player\Player;
use pocketmine\utils\Config;

use isrdxv\practice\arena\Arena;
use isrdxv\practice\Loader;

class Creator
{
  
  private Player $player;
  
  private Arena $arena;
  
  public function __construct(Player $player, Arena $arena)
  {
    $this->player = $player;
    $this->arena = $arena;
  }
  
  public function getPlayer(): Player
  {
    return $this->player;
  }
  
  public function getArena(): Arena
  {
    return $this->arena;
  }
  
  /**
   * solo = 2
   * duo = 4
   * squad = 6
   */
  public function setSlots(int $slot): void
  {
    $this->getArena()->slots = $slot;
    $this->getPlayer()->sendMessage("Usa /practice mode <string: nodebuff|combo|gapple>");
  }
  
  public function setMode(string $mode): void
  {
    $this->getArena()->mode = $mode;
    $this->getPlayer()->sendMessage("Usa /practice typeMode <string: 0 FFA|1 Duel>");
  }
  
  public function setTypeMode(int $type_mode): void
  {
    $this->getArena()->type_mode = $type_mode;
    $this->getPlayer()->sendMessage("Usa /practice ranked <bool: true Type from Arena>");
  }
  
  public function setRanked(bool $value): void
  {
    $this->getArena()->ranked = $value;
    $this->getPlayer()->sendMessage("Usa /practice spawn <int: 2 Spawns for Arena>");
  }
  
  public function setSpawn(int $spawn, array $location): void
  {
    $this->getArena()->spawns["spawn-{$spawn}"] = $location;
    $this->getPlayer()->sendMessage("Ready arena");
  }
  
  public function save(): void
  {
    $arena = new Config(Loader::getInstance()->getDataFolder() . "arenas" . DIRECTORY_SEPARATOR . $this->getArena()->getName() . ".yml", Config::YAML);
      $arena->setAll($this->getArena()->__toArray());
    $arena->save();
  }
  
}
