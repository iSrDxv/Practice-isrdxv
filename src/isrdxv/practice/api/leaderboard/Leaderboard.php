<?php

namespace isrdxv\practice\api\leaderboard;

use pocketmine\entity\{
  Human,
  Skin,
  Location
};
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\event\entity\{
  EntityDamageEvent,
  EntityDamageByEntityEvent
};
use pocketmine\player\Player;

class Leaderboard extends Human
{
  public function __construct(Location $location, Skin $skin, CompoumdTag $nbt = null)
  {
    parent::__construct($location, $skin, $nbt);
    $this->skin = new Skin("Standard_Custom", str_repeat("\x00", 8192), "", "geometry.humanoid.custom");
    $this->sendSkin();
    $this->setImmobile();
  }
  
  public function attack(): void
  {
    if ($event instanceof EntityDamageByEntityEvent) {
      if ($damager instanceof Player) {
        return;
      }
    }
  }
  
  public function onUpdate(int $currentTick): bool
  {
    $this->setNameTagVisible(true);
    return parent::onUpdate($currentTick);
  }
  
}
