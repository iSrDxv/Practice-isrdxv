<?php

namespace isrdxv\practice\arena\event;

use isrdxv\practice\arena\event\ArenaEvent;

use pocketmine\utils\TextFormat;

class ArenaDeleteEvent extends ArenaEvent
{
  
  /** @var string|null = "" **/
  protected string $message;
  
  public function getMessageDelete(): string
  {
    return $this->message;
  }
  
  public function setMessageDelete(string $message): void
  {
    $this->message = ($message !== null) ? TextFormat::colorize($message) : "";
  }
  
}
