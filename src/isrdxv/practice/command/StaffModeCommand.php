<?php

namespace isrdxv\practice\command;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class StaffModeCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("staffmode", "Authorized personal only", "/staffmode <chat|info>", ["sm"]);
    parent::setPermission("staffmode.command");
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
    if (empty($args[0])) {
      $session = SessionManager::getInstance()->get($sender->getName());
      if ($session->isStaff()) {
        $session->setStaffChat(true);
        $session->giveStaffModeItems();
      } else {
        $session->setStaff(false);
        $session->setStaffChat(false);
      }
    }
  }

}