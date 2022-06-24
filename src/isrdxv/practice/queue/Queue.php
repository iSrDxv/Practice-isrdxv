<?php

namespace isrdxv\practice\queue;

use isrdxv\practice\session\Session;
use isrdxv\practice\arena\ArenaManager;
use isrdxv\practice\game\GameManager;
use isrdxv\practice\Loader;

use pocketmine\entity\Location;
use pocketmine\Server;

class Queue
{
  private int $id;
  
  private string $name;
  
  private int $modeType;
  
  private array $players = [];
  
  private array $spectators = [];
  
  public function __construct(string $id, string $name, int $modeType = ArebaManager::TYPE_DUEL)
  {
    $this->id = $id;
    $this->name = $name;
    $this->modeType = $modeType;
  }
  
  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }
  
  public function getModeType(): int
  {
    return $this->modeType;
  }
  
  public function getPlayers(): array
  {
    return $this->players;
  }
  
  public function addPlayer(Session $session): void
  {
    if ($session->hasQueue()) {
      $session->getPlayer()->sendMessage("You already are in a Queue");
      return;
    }
    $session->giveQueueItems();
    $this->players[] = $session;
    $session->setQueue($this);
    $this->joinGame();
  }
  
  public function addSpectator(Session $session): void
  {
    if ($session->hasQueue()) {
      $session->getPlayer()->sendMessage("You already are in a Queue");
      return;
    }
    $this->spectators[] = $session;
    $session->setQueue($this);
    //$this->teleportArena($session->getPlayer());
  }
  
  public function joinGame(): void
  {
    if (count($this->players) === 2) {
      $game = $this->getGameAvailable(strtolower($this->getName()), $this->getModeType());
      foreach($this->players as $session) {
        if (isset($game)) {
          $game->addPlayer($session);
        } else {
          $session->sendMessage("no hay arenas LMAFAO");
          $world = $session->getPlayer()->getServer()->getWorldManager()->getWorldByName(Loader::getInstance()->getConfig()->get("lobby-name"));
          $session->getPlayer()->teleport($world->getSafeSpawn());
          $session->giveLobbyItems();
          $this->deletePlayer($session);
          $session->setQueue(null);
        }
      }
    }
  }
  
  public function resetPlayers(): void
  {
    $this->spectators = [];
    $this->players = [];
  }
  
  public function deletePlayer(Session $session): void
  {
    unset($this->players[array_search($session, $this->players, true)]);
  }
  
  public function getGameAvailable(string $mode, int $modeType): ?Game
  {
    foreach(GameManager::getInstance()->getGames() as $game) {
      if ($game->getPhase() === GameManager::PHASE_WAITING) {
        if ($game->getArenaMode() === $mode) {
          if ($game->getArenaModeType() === $modeType) {
            return $game;
          }
        }
      }
    }
    return null;
  }
  
  /*public function teleportArena(Player $player): void
  {
    $world = Server::getInstance()->getWorldManager()->getWorldByName($this->getArena()->getName());
    $spawn = $this->getArena()->getSpawns()[array_rand($this->getArena()->getSpawns())];
    $player->teleport(new Location($spawn["x"], $spawn["y"], $spawn["z"], $world, $spawn["yaw"], $spawn["pitch"]));
    //message
  }*/
  
}
