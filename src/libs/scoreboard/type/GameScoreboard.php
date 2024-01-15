<?php

namespace libs\scoreboard\type;

use libs\scoreboard\Scoreboard;

use isrdxv\practice\session\Session;
use isrdxv\practice\game\Game;
use isrdxv\practice\Loader;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class GameScoreboard extends Scoreboard
{
  private Session $opponent;
  
  private Game $game;
  
  public function __construct(Player $victim, Session $opponent, Game $game)
  {
    $this->opponent = $opponent;
    $this->game = $game;
    parent::__construct($victim);
  }
  
  public function show(): void
  {
    $this->title = "§bDuel";
    parent::spawn();
  }
  
  public function showLines(): void
  {
    $date = new DateTime("NOW", new DateTimeZone("America/Mexico_City"));
    parent::setLine(1, "");
    parent::setLine(2, $date->format("Y/m/d H:i"));
    parent::setLine(3, TextFormat::colorize(" &bFighting: &f" . $this->opponent->getName()));
    parent::setLine(4, " ");
    //parent::setLine(4, TextFormat::colorize(" &bTime: &f" . gmdate()));
    parent::setLine(5, TextFormat::colorize(" &aYour Ping: &f" . parent::getPlayer()->getNetworkSession()->getPing()));
    parent::setLine(6, TextFormat::colorize(" &cTheir Ping: &f" . $this->opponent->getPing()));
    parent::setLine(7, " ");
    parent::setLine(8, TextFormat::colorize(" &o&7" . Loader::getInstance()->getConfig()->getNested("server-address")));
    parent::setLine(9, TextFormat::colorize("&7"));
  }
  
}