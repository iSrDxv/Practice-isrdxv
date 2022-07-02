<?php

namespace isrdxv\practice\command;

use DateTime;
use DateTimeZone;

use pocketmine\command\{
  Command,
  CommandSender,
  utils\InvalidCommandSintaxException
};
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;

use isrdxv\practice\session\SessionManager;

class BanCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("ban", "Ban a specific user", "/ban <username> <reason> <time: 2022-06-26 00:45:30:+2|null>",["b"]);
    $this->setPermission("ban.command");
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$this->testPermission($sender)) {
      return;
    }
    if (count($args) === 0) {
      throw new InvalidCommandSintaxException();
    }
    $username = array_shift($args);
    $reason = implode(" ", $args);
    $time = null;
    if (is_string($args[2])) {
      if ($this->validateDate($args[2])) {
        $time = new DateTime($args[2], new DateTimeZone("+2"));
      }
    }
    if ($sender->getServer()->getNameBans()->isBanned($name)) {
      return;
    }
    $sender->getServer()->getNameBans()->addBan($name, $reason, $time, $sender->getName());
    if (($player = $sender->getServer()->getPlayerExact($name)) instanceof Player) {
      $player->kick($reason !== "" ? $reason : "Banned by Console");
    }
  }
  
  public function validateDate(string $date): bool
  {
    $format = "Y\Y-n\n-j\j H\H:i\i:s\s";
    $d = DateTime::createFromFormat($format, $date);
    return $d->format($format) === $date;
  }
  
}
