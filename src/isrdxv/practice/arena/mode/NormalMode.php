<?php

namespace isrdxv\practice\arena\mode;

use pocketmine\math\Vector3;
use pocketmine\world\{
  World,
  Position
};

class NormalMode extends Position
{
  
  public float|int $yaw;
  
  public float|int $pitch;
  
  public function __construct(float|int $x, float|int $y, float|int $z, ?World $world = null, float|int $yaw = 0.0, float|int $pitch = 0.0)
  {
    $this->yaw = $yaw;
    $this->pitch = $pitch;
    parent::__construct($x, $y, $z, $world);
  }
  
  public function getYaw(): float|int
  {
    return $this->yaw;
  }
  
  public function getPitch(): float|int
  {
    return $this->pitch;
  }
  
  public function toObject(?World $world, Vector3 $pos, float|int $yaw, float|int $pitch): self
  {
    return new self($pos->x, $pos->y, $pos->z, $yaw, $pitch);
  }
  
  public function __toString(): string
  {
    return "{$this->x}:{$this->y}:{$this->z}:{$this->yaw}:{$this->pitch}";
  }
  
}
