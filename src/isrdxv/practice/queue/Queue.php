<?php

namespace isrdxv\practice\queue;

use isrdxv\practice\session\Session;
use isrdxv\practice\arena\Arena;

use pocketmine\entity\Location;
use pocketmine\Server;

class Queue
{
  private string $id;
  
  private Arena $arena;
  
  private array $players;
  
  private array $spectators;
  
  public function __construct(int $id, Arena $arena)
  {
    $this->id = $id;
    $this->arena = $arena;
  }
  
  public function getId(): int
  {
    return $this->id;
  }

  public function getArena(): Arena
  {
    return $this->arena;
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
  }
  
  public function addSpectator(Session $session): void
  {
    if ($session->hasQueue()) {
      $session->getPlayer()->sendMessage("You already are in a Queue");
      return;
    }
    $this->teleportArena($session->getPlayer());
    $this->spectators[] = $session;
    $session->setQueue($this);
  }
  
  public function deleteAllPlayers(): void
  {
    $this->spectators = [];
    $this->players = [];
  }
  
  public function teleportArena(Player $player): void
  {
    $world = Server::getInstance()->getWorldManager()->getWorldByName($this->getArena()->getName());
    $spawn = $this->getArena()->getSpawns()[array_rand($this->getArena()->getSpawns())];
    $player->teleport(new Location($spawn["x"], $spawn["y"], $spawn["z"], $world, $spawn["yaw"], $spawn["pitch"]));
    //message
  }
  
}