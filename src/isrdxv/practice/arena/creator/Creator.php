<?php

namespace isrdxv\practice\arena\creator;

use pocketmine\player\Player;
use pocketmine\utils\Config;

use isrdxv\practice\arena\creator\CreatorData;
use isrdxv\practice\arena\mode\ModeType;
use isrdxv\practice\Loader;

class Creator
{
  
  private Player $player;
  
  private CreatorData $data;
  
  public function __construct(Player $player, CreatorData $data)
  {
    $this->player = $player;
    $this->data = $data;
  }
  
  public function getPlayer(): Player
  {
    return $this->player;
  }
  
  public function getData(): CreatorData
  {
    return $this->data;
  }
  
  public function setMode(string $mode): void
  {
    if (!in_array(ModeType::MODES_LIST)) {
      $modes = explode(",", ModeType::MODES_LIST);
      $this->getPlayer()->sendMessage("Usa /practice mode <string: {$modes}>");
      return;
    }
    $this->data->mode = $mode;
    $this->getPlayer()->sendMessage("Usa /practice typeMode <string: 0 FFA|1 Duel>");
  }
  
  public function setModeType(int $mode_type): void
  {
    if ($mode_type === 1 || $mode_type === 0) {
      $this->data->mode_type = $mode_type;
      $this->getPlayer()->sendMessage("Usa /practice ranked <bool: true Type from Arena>");
      return;
    } else {
      $this->getPlayer()->sendMessage("Usa /practice typeMode <string: 0 FFA|1 Duel>");
    }
  }
  
  public function setRanked(bool $value): void
  {
    $this->data->ranked = $value;
    $this->getPlayer()->sendMessage("Usa /practice spawn <int: 2 Spawns for Arena>");
  }
  
  public function setSpawn(array $location): void
  {
    $spawn = implode(":", $location);
    $this->data->spawns[] = $spawn;
    $this->getPlayer()->sendMessage("Ready arena");
  }
  
  public function save(): void
  {
    $config = new Config(Loader::getInstance()->getDataFolder() . "arenas" . DIRECTORY_SEPARATOR . $this->data->customName . ".yml", Config::YAML);
    $config->setAll($this->data->toArray());
    $config->save();
  }
  
}