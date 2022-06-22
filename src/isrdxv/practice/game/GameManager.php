<?php

namespace isrdxv\practice\game;

use pocketmine\utils\SingletonTrait;

use isrdxv\practice\game\Game;
use isrdxv\practice\arena\{
  Arena,
  ArenaManager
};

class GameManager
{
  use SingletonTrait;
  
  public const PHASE_WAITING = "waiting";
  public const PHASE_STARTING = "starting";
  public const PHASE_PLAYING = "playing";
  public const PHASE_ENDING = "ending";
  
  /** @var Game[] **/
  private array $games = [];
  
  //TODO: this will be a construct very soon XD
  public function loadGames(): void
  {
    if (ArenaManager::getInstance()->getArenas() === []) {
      return;
    }
    foreach(ArenaManager::getInstance()->getArenas() as $arena) {
      $this->createGame($arena);
    }
  }
  
  public function createGame(?Arena $arena): void
  {
    $this->games[$arena->getName()] = new Game($arena);
  }
  
  public function deleteGame(string $name): void
  {
    if (!empty($game = $this->games[$name])) {
      unset($game);
    }
  }
  
  public function getGameByName(string $name): ?Game
  {
    if (empty($name)) return null;
    if (empty($this->games[$name])) return null;
    return $this->games[$name];
  }
  
  public function isOcuppied(): int
  {
    $count = 0;
    foreach($this->getGames() as $game) {
      if ($game->getPhase() === self::PHASE_PLAYING) {
        $count++;
      }
    }
    return $count;
  }
  
  public function getGames(): array
  {
    return $this->games;
  }
  
}