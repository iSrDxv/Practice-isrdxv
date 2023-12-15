<?php
declare(strict_types=1);

namespace isrdxv\practice\arena;

use isrdxv\practice\arena\mode\NormalMode;

class Arena
{
  public const MAX_PLAYERS = 2;
  
  /** @var String **/ 
  private string $name;
  
  /** @var String **/
  private string $mode;
  
  /**
   * true = yes, false = no
   **/
  private bool $ranked;
  
  /** @var Int
   * 0 = FFA | 1 = Duel
   */
  private int $mode_type;
  
  /** @var Vector3[] **/
  private array $spawns = [];
  
  public function __construct(string $name, string $mode, bool $ranked, int $mode_type, array $spawns) 
  {
    $this->name = $name;
    $this->mode = $mode;
    $this->ranked = $ranked;
    $this->mode_type = $mode_type;
    foreach($spawns as $spawn) {
      $position = explode(":", $spawn);
      $this->spawns[] = new NormalMode(floatval($position[0]), floatval($position[1]), floatval($position[2]), null, floatval($position[3]), floatval($position[4]));
    }
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getSlots(): int
  {
    return $this->slot;
  }
  
  public function getMode(): string
  {
    return $this->mode;
  }
  
  public function getRanked(): bool
  {
    return $this->ranked;
  }
  
  public function getModeType(): int
  {
    return $this->mode_type;
  }
  
  public function getSpawns(): array
  {
    return $this->spawns;
  }
  
  public function __toArray(): array
  {
    $spawns = [];
    foreach($this->spawns as $spawn) {
      $spawns[] = $spawn->__toString();
    }
    return [
      "world" => $this->name,
      "mode" => $this->mode,
      "ranked" => $this->ranked,
      "type-mode" => $this->type_mode,
      "spawns" => $spawns
    ];
  }
  
}
