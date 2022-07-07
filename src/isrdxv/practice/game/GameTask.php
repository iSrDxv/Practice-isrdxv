<?php

namespace isrdxv\practice\game;

use isrdxv\practice\Loader;
use isrdxv\practice\translation\TranslationMessage;
use isrdxv\practice\session\Session;

use pocketmine\scheduler\Task;

class GameTask extends Task
{
  /** @var Loader **/
  private $loader;
  
  /** @var int **/
  private $time = 5;
  
  public function __construct(Loader $loader)
  {
    $this->loader = $loader;
  }
  
  public function onRun(): void
  {
    foreach($this->loader->getGameManager()->getGames() as $game) {
      if ($game->getPhase() === $this->loader->getGameManager()::PHASE_WAITING) {
        if ($game->getPlayerCount() === 2) {
          $game->setPhase($this->loader->getGameManager()::PHASE_STARTING);
        }
      }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_STARTING) {
        $game->sendAction(function(Session $session): void {
          if ($session->hasQueue()) {
            $session->getQueue()->deletePlayer($session);
            $session->setQueue();
          }
          $player = $session->getPlayer();
          $player->getInventory()->clearAll();
          $player->getArmorInventory()->clearAll();
          //$player->teleport();
        });
        $this->time--;
        if ($this->time <= 0) {
          $game->sendAction(function(Session $session) use($game): void {
            //$session->setScoreboard(new GameScoreboard($session, $game->getPlayers()[1], $game));
          });
        $game->setPhase($this->loader->getGameManager()::PHASE_PLAYING);
        } else {
          $game->sendAction(function(Session $session) {
            $session->sendMessage(new TranslationMessage("game-starting", ["time" => $this->time]));
          });
        }
      }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_PLAYING) {
        $game->setTime();
      }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_ENDING) {
        $this->time = 20;
        $this->time--;
        //I could add a switch but not until I'm done ok
        if ($this->time === 15) {
          foreach($game->getAllPlayers() as $session) {
            //$session->getGame()->deletePlayer($session);
            $session->setGame();
          }
        }elseif ($this->time === 10) {
          $game->getArena()->toReset();
        }elseif ($this->time === 5) {
          $game->toReset();
        }
      }
    }
  }
}