<?php

namespace isrdxv\practice\arena\event;

use isrdxv\practice\arena\event\ArenaEvent;

use pocketmine\utils\TextFormat;

class ArenaCreationEvent extends ArenaEvent
{
  /** @var string|null = "" **/
  protected string $message;
  
  public function getMessageCreate(): string
  {
    return $this->message;
  }
  
  public function setMessageCreate(string $message): void
  {
    $this->message = ($message !== null) ? TextFormat::colorize($message) : "";
  }
  
}
