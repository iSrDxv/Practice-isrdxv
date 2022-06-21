<?php

namespace libs\scoreboard\type;

use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\player\Player;

use libs\scoreboard\Scoreboard;

use isrdxv\practice\Loader;
use isrdxv\practice\queue\QueueManager;
use isrdxv\practice\game\GameManager;

class LobbyScoreboard extends Scoreboard
{
  
  public function __construct(Player $player)
  {
    parent::__construct($player);
  }
  
  public function show(): void
  {
    $this->title = TextFormat::colorize(Loader::getInstance()->getConfig()->getNested("server-name") . " &r&f| &l&bPractice");
    parent::spawn();
  }
  
  public function showLines(): void
  {
    parent::setLine(1, TextFormat::colorize(""));
    parent::setLine(2, TextFormat::colorize(" &bOnline: &f" . count(Server::getInstance()->getOnlinePlayers())));
    parent::setLine(3, TextFormat::colorize(" &bPing: &f" . parent::getPlayer()->getNetworkSession()->getPing()));
    parent::setLine(4, TextFormat::colorize(" &bIn Game: &f" . count(GameManager::getInstance()->getGames())));
    parent::setLine(5, TextFormat::colorize(" &bQueued: &f" . count(QueueManager::getInstance()->getQueues())));
    parent::setLine(6, TextFormat::colorize(" &o&7" . Loader::getInstance()->getConfig()->getNested("server-address")));
    parent::setLine(7, TextFormat::colorize("§f"));
  }
  
}
