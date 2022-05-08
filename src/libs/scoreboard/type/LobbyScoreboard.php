<?php

namespace libs\scoreboard\type;

use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\player\Player;

use libs\scoreboard\Scoreboard;

use isrdxv\practice\Loader;
use isrdxv\practice\queue\QueueManager;
use isrdxv\practice\game\GameManagaer;

class LobbyScoreboard extends Scoreboard
{
  
  public function __construct(Player $player)
  {
    parent::__construct($player);
  }
  
  public function show(): void
  {
    $this->title = TextFormat::colorize("&l&bPractice &r&f| " . Loader::getInstance()->getConfig()->getNested("server-name"));
    parent::init();
  }
  
  public function showLines(): void
  {
    parent::setLine(1, TextFormat::colorize("§f§f"));
    parent::setLine(2, TextFormat::colorize(" &bOnline: &f" . count(Server::getInstance()->getOnlinePlayers())));
    //parent::getPlayer()->getNetworkSession()->getPing();
    parent::setLine(3, TextFormat::colorize(" &bIn Game: &f10"));
    parent::setLine(4, TextFormat::colorize(" &bQueued: &f5"));
    parent::setLine(5, TextFormat::colorize(" &o&7play.darkneesmcpe.cf"));
    parent::setLine(6, TextFormat::colorize("§f§f"));
  }
  
}