<?php
declare(strict_types=1);

namespace isrdxv\practice\entity;

use pocketmine\{
  world\World,
  world\particle\FloatingTextParticle
};
use pocketmine\math\Vector3;

abstract class Hologram
{
  private Vector3 $position;
  
  private World $world;
  
  /** Recent key of an array **/
  protected int $currentKey = 0;
  
  protected FloatingTextParticle $particle;
  
  public function __construct(Vector3 $position,  World $world)
  {
    $this->position = $position;
    $this->world = $world;
  }
  
  /**
   * Don't forget to add this function
   * when extending this class, thank you
   */
  abstract protected function place(bool $update = false): void;
  
  //NOTE: perfect for a repeat task
  public function update(): void
  {
    $this->place();
  }
  
  public function move(World $world, Vector3 $position): void
  {
    $original = $this->world;
    $this->world = $world;
    $this->position = $position;
    if (($particle = $this->particle) !== null) {
      $particle->setInvisible();
      $pk = $particle->encode($position);
      if ($pk > 0) {
        foreach($pk as $pkt) {
          $original->broadcastPacketToViewers($position, $pkt);
        }
      }
    }
  }
  
  public function isThisPlaced(): bool
  {
    return $this->particle !== null;
  }
  
}