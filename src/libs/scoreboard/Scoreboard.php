<?php

/* 
*   ___ ___  ___ _      _  _   _ 
*  / __| _ \/ __| |    /_\| | | |
*  \__ \   / (__| |__ / _ \ |_| |
*  |___/_|_\\___|____/_/ \_\___/ 
*
* @author: iSrDxv (SrClau)
* @status: Beta
*/

namespace libs\scoreboard;

use pocketmine\player\Player;

use pocketmine\network\mcpe\protocol\{
  SetDisplayObjectivePacket,
  SetScorePacket,
  SetScoreboardIdentityPacket,
  RemoveObjectivePacket
};
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

class Scoreboard
{
  
  public static function create(Player $player, string $title): Scoreboard
  {
    $self = new Scoreboard($player);
    $self->title = $title;
    return $self;
  }
  
  /** @var Player **/
  public Player $player;
  
  public string $title;
  
  public bool $spawned = false;
  
  /** @var Array int **/
  public array $lines = [];
  
  public function __construct(Player $player)
  {
  $this->player = $player;
  }
  
  public function getPlayer(): Player
  {
    return $this->player;
  }
  
  public function isSpawned(): bool
  {
    return $this->spawned;
  }
  
  public function init(): void 
  {
    if (!$this->spawned) {
      $pk = SetDisplayObjectivePacket::create(SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR, $this->getPlayer()->getName(), $this->title, "dummy", SetDisplayObjectivePacket::SORT_ORDER_ASCENDING);
      $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
      $this->spawned = true;
      return;
    } 
  }
  
  public function remove(): void
  { 
    if (!$this->spawned) {
      return;
    }
    $this->spawned = false;
    $pk = RemoveObjectivePacket::create($this->getPlayer()->getName());
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
  }
  
  public function setLine(int $line, string $description = ""): void
  {
    /*if (isset($this->line[$line])) {
      $pk = new SetScorePacket(SetScorePacket::TYPE_REMOVE, [$this->lines[$line]]);
      $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
      unset($this->lines[$line]);
      return;
    }*/
    $entry = new ScorePacketEntry();
    $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
    
    $entry->score = $line;
    $entry->scoreboardId = $line;
    $entry->customName = $description;
    $entry->objectiveName = $this->getPlayer()->getName();
    $this->lines[$line] = $entry;
    
    $pk = new SetScorePacket();
    $pk->type = SetScorePacket::TYPE_CHANGE;   
    $pk->entries[] = $entry;
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
  }
  
  public function setAllLine(array $lines): void
  {
    $entries = [];
    for ($i = 0; $i < 15; $i++) {
    $entry = new ScorePacketEntry();
    $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
    $entry->scoreboardId = $i; $entry->score = $i;
    $entry->customName = $lines[$i];
    $entry->objectiveName = $this->getPlayer()->getName();
    $this->lines = $lines;
    $entries[] = $entry;
    }
    
    $pk = SetScorePacket::create(SetScorePacket::TYPE_CHANGE, $entries);
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
  }
  
  public function removeLine(int $id): void
  {
    $line = $this->lines[$id];
    if (isset($line)) {
      $pk = SetScorePacket::create(SetScorePacket::TYPE_REMOVE, [$line]);
      $this->getPlayer()->getNetworkSession()->sendDataPacket();
      unset($line);
    }
  }
  
  public function removeAllLine(): void
  {
    if (empty($this->lines) && ($this->spawned !== true)) {
      return;
    }
    $pk = SetScorePacket::create(SetScorePacket::TYPE_REMOVE, $this->lines);
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
    $this->lines = [];
  }
  
}
