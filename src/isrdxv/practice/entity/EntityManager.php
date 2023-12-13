<?php

namespace isrdxv\practice\entity;

use isrdxv\practice\Laoder;
use isrdxv\practice\entity\types\{
  LeaderboardElo,
  LeaderboardKDR,
  LeaderboardKills
};

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\{
  EntityFactory,
  Human,
  EntityDataHelper
};
use pocketmine\world\World;

class EntityManager
{
  
  public function __construct(Loader $loader)
  {
    $entity = EntityFactory::getInstance();
    $entity->register(LeaderboardElo::class, function(World $world, CompoundTag $nbt): LeaderboardElo {
      return new LeaderboardElo(EntityDataHelper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
    }, ["LeaderboardElo"]);
  }
  
}