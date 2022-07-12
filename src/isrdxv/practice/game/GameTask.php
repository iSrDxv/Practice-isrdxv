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
          $game->sendAction(function(Session $session) use($game): void {
            foreach($game->getPlayers() as $opponent) {
              $session->sendMessage(new TranslationMessage("game-text", [
              "line" => "\n",
              "kit_name" => $game->getKit()->getName(),
              "name" => $opponent->getName(),
              "opp_ping" => $opponent->getPing()
            ]));
            }
          });
          $game->setPhase($this->loader->getGameManager()::PHASE_STARTING);
        }
      }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_STARTING) {
        $game->sendAction(function(Session $session) use($game): void {
          if ($session->hasQueue()) {
            $session->getQueue()->deletePlayer($session);
            $session->setQueue();
          }
          $player = $session->getPlayer();
          $player->getInventory()->clearAll();
          $player->getArmorInventory()->clearAll();
          $session->setKit($game->getKit());
          for($slot = 0; $slot < 2; $slot++) {
            //TODO: load chunk
            $world = $this->loader->getServer()->getWorldManager()->getWorldByName($game->getArena()->getName());
            $pos = $game->getArena()->getSpawns()[$slot];
            $world->loadChunk($pos->getX(), $pos->getZ());
            $player->teleport($pos);
          }
        });
        $this->time--;
        if ($this->time <= 0) {
          $game->sendAction(function(Session $session) use($game): void {
            //$session->getPlayer()->sendTitle();
            foreach($game->getPlayers() as $opponent) {
              $session->setScoreboard(new GameScoreboard($session->getPlayer(), $opponent, $game));
            }
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
            $session->getGame()->deletePlayer($session);
            $session->setGame();
          }
        }elseif ($this->time === 10) {
          $game->getArena()->toReset();
        }elseif ($this->time === 5) {
          $game->toReset();
        }elseif ($this->time === 0) {
          //destroy world
        }
      }
    }
  }
}
