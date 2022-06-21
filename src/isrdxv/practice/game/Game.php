<?php

namespace isrdxv\practice\game;

use isrdxv\practice\arena\Arena;

use pocketmine\utils\TextFormat;

class Game
{
  private Arena $arena;
  
  private ?string $mode = null;
  
  private ?string $phase = null;
  
  //private string $type; solo,duo,squad
  
  /** @var Session[] **/
  private array $players = [];
  
  //private array $spectators = [];
  
  private int $type_mode;
  
  private int $time = 0;
  
  private Kit $kit;
  
  public function __construct(?Arena $arena = null)
  {
    $this->arena = $arena;
  }
  
  public function getArena(): ?Arena
  {
    return $this->arena;
  }
  
  public function getPlayers(): array
  {
    return $this->players;
  }
  
  public function getTime(): int
  {
    return $this->time;
  }
  
  public function addPlayer(Session $session): void
  {
    if ($this->isGamePlaying()) {
      return;
    }
    $this->players[] = $player;
    $session->setGame($this);
  }
  
  public function deletePlayer(string $username): void
  {
    //unset($this->players);
  }
  
  public function getPlayerCount(): int
  {
    return count($this->players);
  }
  
}