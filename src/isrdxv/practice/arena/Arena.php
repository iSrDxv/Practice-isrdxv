<?php

namespace isrdxv\practice\arena;

use isrdxv\practice\arena\ArenaManager;

class Arena
{
  
  /** @var String **/ 
  private string $name;
  
  /** @var Int **/
  private int $slots;
  
  /** @var String **/
  private string $mode;
  
  /** @var String **/
  private string $type;
  
  /**
   * true = yes, false = no
   **/
  private bool $ranked;
  
  /** @var Int
   * 0 = FFA | 1 = Duel
   */
  private int $mode_type;
  
  /** @var Array **/
  private array $spawns;
  
  public function __construct(string $name, int $slots, string $mode, string $type, bool $ranked, int $mode_type, array $spawns = []) 
  {
    $this->name = $name;
    $this->slots = isset($slots) ? $slots : 2;
    $this->mode = empty($mode) ? "nodebuff" : $mode;
    $this->type = empty($type) ? "solo" : $type;
    $this->ranked = empty($ranked) ? false : $ranked; 
    $this->mode_type = empty($mode_type) ? ArenaManager::TYPE_FFA : $mode_type;
    $this->spawns = ($spawns === []) ? ["spawn-1" => [], "spawn-2" => []] : $spawns;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getSlots(): int
  {
    return $this->slots;
  }
  
  public function getMode(): string
  {
    return $this->mode;
  }
  
  public function getType(): string
  {
    return $this->type;
  }
  
  public function getRanked(): bool
  {
    return $this->ranked;
  }
  
  public function getTypeMode(): int
  {
    return $this->mode_type;
  }
  
  public function getSpawns(): array
  {
    return $this->spawns;
  }
  
  public function __toArray(): array
  {
    return [
      "world" => $this->name,
      "slots" => $this->slots,
      "mode" => $this->mode,
      "type" => $this->type,
      "ranked" => $this->ranked,
      "type-mode" => $this->type_mode,
      "spawns" => $this->spawns
    ];
  }
  
}
