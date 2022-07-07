<?php

namespace isrdxv\practice\arena\mode;

use pocketmine\math\Vector3;

class NormalMode extends Vector3
{
  
  public float|int $yaw;
  
  public float|int $pitch;
  
  public function __construct(float|int $x, float|int $y, float|int $z, float|int $yaw = 0.0, float|int $pitch = 0.0)
  {
    $this->yaw = $yaw;
    $this->pitch = $pitch;
    parent::__construct($x, $y, $z);
  }
  
  public function getYaw(): float|int
  {
    return $this->yae;
  }
  
  public function getPitch(): float|int
  {
    return $this->pitch;
  }
  
  public function toObject(Vector3 $pos, float|int $yaw, float|int $pitch): self
  {
    return self($pos->x, $pos->y, $pos->z, $yaw, $pitch);
  }
  
  public function __toString(): string
  {
    return "{$this->x}:{$this->y}:{$this->z}:{$this->yaw}:{$this->pitch}";
  }
  
}