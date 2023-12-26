<?php

namespace isrdxv\practice\session;

use isrdxv\practice\session\Session;
use isrdxv\practice\Loader;

use pocketmine\player\Player;
use pocketmine\utils\{
  SingletonTrait,
  Config
};

class SessionManager 
{
  use SingletonTrait;
  
  /** @var Array **/
  private array $sessions = [];
  
  public function create(Player $player): void
  {
    $this->sessions[$player->getName()] = new Session($player);
  }
  
  public function remove(string $username): void
  {
    if (!empty($session = $this->sessions[$username])) {
      unset($session);
    }
  }
  
  public function get(string $username): ?Session
  {
    return $this->sessions[$username] ?? null;
  }
  
  public function set(Player $player, bool $firstJoin = false): void
  {
    $this->create($player);
    $player->sendMessage("Loading your data...");
    if ($firstJoin) {
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.settings", ["xuid" => $player->getXuid(), "scoreboard" => true, "queue" => false, "cps" => false, "auto_join" => false]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.user_data", ["xuid" => $player->getXuid(), "name" => $player->getName(), "custom_name" => "lol", "alias" => "", "language" => Loader::getInstance()->getProvider()->getDefaultLanguage(), "skin" => "", "coin" => 500]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.won_events", ["xuid" => $player->getXuid(), "name" => $player->getName(), "title" => "Enter the server for the first time", "description" => "an event for having entered for the first time, you win 500 coins", "prize" => "500"]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.points", ["xuid" => $player->getXuid(), "combo" => 1000, "gapple" => 1000, "nodebuff" => 1000, "trapping" => 1000, "bridge" => 1000, "classic" => 1000]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.kills", ["xuid" => $player->getXuid(), "combo" => 0, "gapple" => 0, "nodebuff" => 0, "trapping" => 0, "bridge" => 0, "classic" => 0]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.murders", ["xuid" => $player->getXuid(), "combo" => 0, "gapple" => 0, "nodebuff" => 0, "trapping" => 0, "bridge" => 0, "classic" => 0]);
      $firstTimeServer = new DateTime("NOW");
      Loader::getInstance()->getDatabase()->executeInsert("claude.insert.duration", ["xuid" => $player->getXuid(), "voted" => "0", "donated" => "0", "muted" => "0", "lastplayed" => "0", "totalonline" => "0", "time_join_server" => date_format($firstTimeServer, "Y-m-d-H-i"), "warnings" => 0]);
      //$player->sendForm(new RulesForm());
      return;
    }
    $xuid = $player->getXuid();
    $session = $this->get($player->getName());//->loadData();
    Loader::getInstance()->getDatabase()->executeSelect("SELECT * FROM duration,bans,murders,kills,points,won_events,user_data,settings WHERE duration.xuid = '$xuid' AND bans.xuid = '$xuid' AND murders.xuid = '$xuid' AND kills.xuid = '$xuid' AND points.xuid = '$xuid' AND won_events.xuid = '$xuid' AND user_data.xuid = '$xuid' AND settings.xuid = '$xuid'", [], function(array $rows) use($session, $player) {
      if ($player instanceof Player) {
        var_dump($rows);
        if (isset($rows[0]) && $player->getXuid() !== null) {
          //$session->loadData();
        }
      }
    }, null);
  }
  
  public function getSessions(): array
  {
    return $this->sessions;
  }
  
  public function isSession(string $username): bool
  {
    return (isset($this->sessions[$username])) ? true : false;
  }

}