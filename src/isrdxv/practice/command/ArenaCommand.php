<?php

namespace isrdxv\practice\command;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\player\Player;
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
    break;
    case "set":
    break;
    }
  }
  
}
