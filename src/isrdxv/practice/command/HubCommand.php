<?php

namespace isrdxv\practice\command;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\{
  World,
  WorldManager
};

use isrdxv\practice\Loader;
use isrdxv\practice\session\{
    Session,
    SessionManager
};

class HubCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("hub", "Go back to the lobby", "/hub", ["lobby"]);
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    $world = Server::getInstance()->getWorldManager()->getWorldByName(Loader::getInstance()->getConfig()->get("lobby-name"));
    $session = SessionManager::getInstance()->get($sender->getName());
    $session->giveLobbyItems();
    $sender->teleport($world->getSafeSpawn());
  }
  
}