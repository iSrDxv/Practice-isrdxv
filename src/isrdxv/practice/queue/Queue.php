<?php
declare(strict_types=1);

namespace isrdxv\practice\queue;

use isrdxv\practice\session\Session;
use isrdxv\practice\arena\ArenaManager;
use isrdxv\practice\game\GameManager;
use isrdxv\practice\translation\TranslationMessage;
use isrdxv\practice\Loader;

use pocketmine\entity\Location;
use pocketmine\Server;

class Queue
{
  private string $id;
  
  private string $name;
  
  private int $mode_type;
  
  private bool $ranked;
  
  private array $players = [];
  
  private array $spectators = [];
  
  public function __construct(string $id, string $name, int $mode_type = ArenaManager::TYPE_DUEL, bool $ranked = false)
  {
    $this->id = $id;
    $this->name = $name;
    $this->mode_type = $mode_type;
    $this->ranked = $ranked;
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
    return $this->mode_type;
  }
  
  public function getRanked(): bool
  {
    return $this->ranked;
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
      $session->sendMessage("You already are in a Queue");
      return;
    }
    $this->spectators[] = $session;
    $session->setQueue($this);
    //$this->teleportArena($session->getPlayer());
  }
  
  public function joinGame(): void
  {
    if (count($this->players) === 2) {
      $game = GameManager::getInstance()->getGameAvailable(strtolower($this->getName()), $this->getModeType(), $this->getRanked());
      foreach($this->players as $session) {
        if (isset($game)) {
          $game->addPlayer($session);
          $session->sendMessage(new TranslationMessage("queue-join-arena"));
        } else {
          $session->sendMessage(new TranslationMessage("queue-no-arenas"));
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
  
  /*public function teleportArena(Player $player): void
  {
    $world = Server::getInstance()->getWorldManager()->getWorldByName($this->getArena()->getName());
    $spawn = $this->getArena()->getSpawns()[array_rand($this->getArena()->getSpawns())];
    $player->teleport(new Location($spawn["x"], $spawn["y"], $spawn["z"], $world, $spawn["yaw"], $spawn["pitch"]));
    //message
  }*/
  
}
