<?php

namespace isrdxv\practice\game;

use isrdxv\practice\arena\Arena;
use isrdxv\practice\game\{
  GameManager,
  GameException
};

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
    if (empty($arena)) {
      throw new GameException("I can't be empty :c");
    }
    $this->arena = $arena;
    $this->mode = $arena->getMode();
    $this->type_mode = $arena->getTypeMode();
    //$this->kit = KitManager::getInstance()->getKitByName($arena->getMode());
    $this->phase = GameManager::PHASE_WAITING;
  }
  
  public function getArena(): Arena
  {
    return $this->arena;
  }
  
  public function getArenaMode(): string
  {
    return $this->mode;
  }
  
  public function getArenaTypeMode(): int
  {
    return $this->type_mode;
  }
  
  public function getPhase(): string
  {
    return $this->phase;
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
    if ($this->isGamePlaying($session)) {
      return;
    }
    $this->players[] = $session;
    $session->setGame($this);
  }
  
  public function isGamePlaying(Session $session): bool
  {
    return array_key_exists($session, $this->players);
  }
  
  public function deletePlayer(Session $session): void
  {
    unset($this->players[array_search($session, $this->players, true)]);
  }
  
  public function getPlayerCount(): int
  {
    return count($this->players);
  }
  
  public function toReset(): void
  {
    $this->players = [];
    //$this->spectators = [];
    $this->phase = GameManager::PHASE_WAITING;
  }
  
}