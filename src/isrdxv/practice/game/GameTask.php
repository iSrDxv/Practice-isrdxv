<?php

namespace isrdxv\practice\game;

use isrdxv\practice\Loader;
use isrdxv\practice\arena\Arena;
use isrdxv\practice\translation\TranslationMessage;
use isrdxv\practice\session\Session;

use libs\scoreboard\type\GameScoreboard;

use pocketmine\scheduler\Task;
use pocketmine\world\sound\ClickSound;

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
        if ($game->getPlayerCount() === Arena::MAX_PLAYERS) {
          $game->sendAction(function(Session $session) use($game): void {
            $opponent = $game->getPlayers()[1];
            $session->sendMessage(new TranslationMessage("game-text", [
              "line" => "\n",
              "space" => " ",
              "kit_name" => $game->getKit()->getName(),
              "name" => $opponent->getName(),
              "opp_ping" => $opponent->getPing()
            ]));
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
          for($slot = 0; $slot < Arena::MAX_PLAYERS; $slot++) {
            $world = $game->getWorld();
            $spawn = $game->getArena()->getSpawns()[$slot];
            $world->loadChunk($spawn->getX(), $spawn->getZ());
            $spawn->world = $world;
            $player->teleport($spawn);
          }
        });
        $this->time--;
        if ($this->time <= 0) {
          $game->sendAction(function(Session $session) use($game): void {
            $session->getPlayer()->sendTitle(TextFormat::colorize("¡¡Game started!!"));
            $opponent = $game->getPlayers()[1];
            $session->setScoreboard(new GameScoreboard($session->getPlayer(), $opponent, $game));
          });
        $game->setPhase($this->loader->getGameManager()::PHASE_PLAYING);
        } else {
          $game->sendAction(function(Session $session) {
            $session->sendMessage(new TranslationMessage("game-starting", ["time" => $this->time]));
            $session->sendSound(new ClickSound(5));
          });
        }
      }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_PLAYING) {
        $game->setTime();
      }elseif ($game->getPhase() === $this->loader->getGameManager()::PHASE_ENDING) {
        $this->time = 20;
        $this->time--;
        switch($this->time){
          case 15:
            foreach($game->getAllPlayers() as $session) {
            $session->getGame()->deletePlayer($session);
            $session->setGame();
          }
          break;
          case 10:
            $game->getArena()->toReset();
          break;
          case 5:
            $game->toReset();
          break;
          case 0:
            $game->destroy();
          break;
        }
      }
    }
  }
  
}