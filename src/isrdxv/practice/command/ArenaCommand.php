<?php

namespace isrdxv\practice\command;

use isrdxv\practice\Loader;
use isrdxv\practice\arena\{
  ArenaManager,
  creator\CreatorManager
};

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class ArenaCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("arena", "Create the arenas for the PvP", "/arena <create|set>");
    $this->setPermission("arena.command");
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$sender instanceof Player) {
      $sender->sendMessage("No puedes usar este comando en consola: /{$label}");
      return;
    }
    if (count($args) === 0) {
      $sender->sendMessage("No hay argumentos, por favor usa: " . $this->getUsage());
      return;
    }
    if (strlen($args[0]) < 5) {
      $sender->sendMessage("Los caracteres no pueden ser menores que 5, por favor usa: " . $this->getUsage());
      return;
    }
    switch($args[0]){
    case "create":
      if (Loader::getInstance()->getArenaManager()->getArenaByName($args[1]) !== null && CreatorManager::getInstance()->isCreating($args[1])) {
        $sender->sendMessage("This arena already exists");
        return;
      }
      if (CreatorManager::getInstance()->isCreator($sender->getName())) {
        $sender->sendMessage("You cannot create another arena in creation mode.");
        return;
      }
      $player = Server::getInstance()->getPlayerByExact($sender->getName());
      CreatorManager::getInstance()->setCreator($player, (string)$args[1],(string)$args[2]);
    break;
    case "set":
    break;
    }
  }
  
}
