<?php

namespace isrdxv\practice\command;

use pocketmine\command\{
  Command,
  CommandSender
};

use pocketmine\utils\{
  Config,
  TextFormat
};

use isrdxv\practice\Loader;

class ReportCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("report", "Report a player", "/report <username> <reason>", ["r"]);
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$this->testPermission($sender)) {
      return;
    }
    /*if (empty($args)) {
      return;
    }*/
    $username = str_replace(" ", "_", $args[0]);
  }
}