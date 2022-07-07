<?php
declare(strict_types=1);

namespace isrdxv\practice\game;

use isrdxv\practice\arena\Arena;
use isrdxv\practice\game\{
  GameManager,
  GameException
};
use isrdxv\practice\session\Session;

use pocketmine\utils\TextFormat;

class Game
{
  private Arena $arena;
  
  private ?string $mode = null;
  
  private ?string $phase = null;
  
  //private string $type; solo,duo,squad
  
  /** @var Session[] **/
  private array $players = [];
  
  private array $spectators = [];
  
  private int $mode_type;
  
  private int $time = 0;
  
  private Kit $kit;
  
  public function __construct(?Arena $arena = null)
  {
    if (empty($arena)) {
      throw new GameException("I can't be empty :c");
    }
    $this->arena = $arena;
    $this->mode = $arena->getMode();
    $this->mode_type = $arena->getModeType();
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
  
  public function getArenaModeType(): int
  {
    return $this->mode_type;
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
  
  public function setTime(): void
  {
    $this->time++;
  }
  
  public function setPhase(string $phase): void
  {
    if (!in_array($phase, [GameManager::PHASE_WAITING, GameManager::PHASE_STARTING, GameManager::PHASE_PLAYING, GameManager::PHASE_ENDING], true)) {
      return;
    }
    $this->phase = $phase;
  }
  
  public function getAllPlayers(): array
  {
    return array_merge($this->players, $this->spectators);
  }
  
  public function addPlayer(Session $session): void
  {
    if ($this->isPlaying($session)) {
      return;
    }
    $this->players[] = $session;
    $session->setGame($this);
  }
  
  public function sendAction(\Closure $closure): void
  {
    foreach($this->players as $player) {
      $closure($player);
    }
  }
  
  public function isPlaying(Session $session): bool
  {
    return array_key_exists($session, $this->players);
  }
  
  public function deletePlayer(Session $session, bool $game = false, bool $del_spectator = false): void
  {
    unset($this->players[array_search($session, $this->players, true)]);
    if (!$this->isSpectating($session)) {
      $this->addSpectator($session);
    }
    if ($game) {
      $session->setGame();
      $session->teleportToLobby();
    }
    if ($del_spectator) {
      $this->deleteSpectator($session);
    }
    $session->setGamemode(0);
  }
  
  public function addSpectator($session): void
  {
    $this->spectators[] = $session;
    $session->setGamemode(3);
  }
  
  public function isSpectating(Session $session): bool
  {
    return array_key_exists($session, $this->spectators);
  }
  
  public function deleteSpectator(Session $session): void
  {
    if (!$this->isSpectating($session)) {
      return;
    }
    unset($this->spectators[array_search($session, $this->spectators, true)]);
    $session->setGamemode(0);
  }
  
  public function getPlayerCount(): int
  {
    return count($this->players);
  }
  
  public function finish(Session $session, bool $global = true): void
  {
    $this->deletePlayer($session, $global, $global);
      $this->setPhase(GameManager::PHASE_ENDING);
  }
  
  public function toReset(): void
  {
    $this->players = [];
    $this->spectators = [];
    $this->phase = GameManager::PHASE_WAITING;
  }
  
}
