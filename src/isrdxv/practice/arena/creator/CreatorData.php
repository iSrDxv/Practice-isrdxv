<?php

namespace isrdxv\practice\arena\creator;

class CreatorData
{
  
  public string $customName = "Arena_God";
  
  public string $world;
  
  public string $mode = "nodebuff";
  
  public bool $ranked = false;
  
  public int $mode_type = 1;
  
  public array $spawns = [];
  
  public function toArray(): array
  {
    return [
      $this->world,
      $this->mode,
      $this->ranked,
      $this->mode_type,
      $this->spawns
    ];
  }
  
}