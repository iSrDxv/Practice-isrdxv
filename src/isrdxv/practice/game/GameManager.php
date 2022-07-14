<?php

namespace isrdxv\practice\game;

use isrdxv\practice\game\Game;
use isrdxv\practice\arena\Arena;
use isrdxv\practice\Loader;

class GameManager
{
  public const PHASE_WAITING = "waiting";
  public const PHASE_STARTING = "starting";
  public const PHASE_PLAYING = "playing";
  public const PHASE_ENDING = "ending";
  
  /** @var Game[] **/
  private array $games = [];
  
  public function __construct(Loader $loader)
  {
    if ($loader->getArenaManager()->getArenas() === []) {
      return;
    }
    foreach($loader->getArenaManager()->getArenas() as $arena) {
      $this->createGame($arena);
    }
  }
  
  public function createGame(?Arena $arena): void
  {
    $this->games[$arena->getName()] = new Game($arena);
  }

  public function getRandomGame(string $mode, int $type, bool $ranked = false): ?Game
  {
    $games = [];
    if (count($this->games) === 0) return null;
    
    foreach($this->games as $class) {
      if ($class->getArenaMode() === $mode && $class->getArenaModeType() === $type && $class->getRanked() === $ranked)
      {
        array_push($games, $class);
      }
    }
    if (count($games) === 0) return null;
    
    return $games[array_rand($games, 1)];
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
  
  public function getGameCount(): int
  {
    $count = 0;
    foreach($this->getGames() as $game) {
      if ($game->getPhase() === self::PHASE_PLAYING) {
        ++$count;
      }
    }
    return $count;
  }
  
  public function getGames(): array
  {
    return $this->games;
  }
  
}
