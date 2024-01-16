<?php
declare(strict_types=1);

namespace isrdxv\practice\game;

use isrdxv\practice\Loader;
use isrdxv\practice\arena\Arena;
use isrdxv\practice\game\{
  GameManager,
  GameException
};
use isrdxv\practice\kit\{
  Kit,
  KitManager
};
use isrdxv\practice\session\{
  Session,
  SessionManager
};
use isrdxv\practice\utils\Utilities;

use libs\worldbackup\WorldBackup;

use pocketmine\Server;
use pocketmine\world\World;
use pocketmine\utils\TextFormat;

class Game
{
  private string $localName;
  
  private Arena $arena;
  
  private World $world;
  
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
    $this->localName = Utilities::getRandomBin();
    $this->arena = $arena;
    $this->world = Server::getInstance()->getWorldByName($arena->getName());
    $this->mode = $arena->getMode();
    $this->mode_type = $arena->getModeType();
    $this->kit = KitManager::getInstance()->getKitByName($arena->getMode());
    $this->phase = GameManager::PHASE_WAITING;
    WorldBackup::createBackup($this->localName, $this->world->getFolderName());
  }
  
  public function getLocalName(): string
  {
    return $this->localName;
  }
  
  public function getArena(): Arena
  {
    return $this->arena;
  }
  
  public function getWorld(): World
  {
    return $this->world;
  }
  
  public function getArenaMode(): string
  {
    return $this->mode;
  }
  
  public function getArenaModeType(): int
  {
    return $this->mode_type;
  }
  
  public function getKit(): Kit
  {
    return $this->kit;
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
  
  public function setWorld(World $world): void
  {
    $this->world = $world;
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
    return in_array($session, $this->players, true);
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
    return in_array($session, $this->spectators, true);
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
    $winner = $this->players[1]; //ucfirst($this->players);
    $winner->getPlayer()->sendTitle("§l§a¡VICTORY!", "§byou won the game");
    $sesssion->getPlayer()->sendTitle("§l§c¡DEFEAT!", "§c{$winner->getName()} §bwon the game");
    $this->setPhase(GameManager::PHASE_ENDING);
  }
  
  public function toReset(): void
  {
    foreach($this->players as $player) {
      $session = SessionManager::getInstance()->get($player->getName());
      $session->teleportToLobby();
    }
    foreach($this->spectators as $spectator) {
      $spec = SessionManager::getInstance()->get($spec->getName());
      $spec->teleportToLobby();
    }
    $this->players = [];
    $this->spectators = [];
    $this->phase = GameManager::PHASE_WAITING;
  }
  
  public function destroy(): void
  {
    WorldBackup::deleteBackup(Loader::getInstance()->getDataFolder() . "backup" . DIRECTORY_SEPARATOR . $this->localName);
  }
  
}