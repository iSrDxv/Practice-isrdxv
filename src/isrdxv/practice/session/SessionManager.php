<?php

namespace isrdxv\practice\session;

use isrdxv\practice\session\Session;
use isrdxv\practice\Loader;

use pocketmine\player\Player;
use pocketmine\utils\{
  SingletonTrait,
  Config
};

use poggit\libasynql\SqlThread;

use DateTime;

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
    if ($firstJoin) {
      Loader::getInstance()->getDatabase()->executeInsert("claude.settings", ["xuid" => $player->getXuid(), "scoreboard" => true, "queue" => false, "cps" => false, "auto_join" => false]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.user_data", ["xuid" => $player->getXuid(), "name" => $player->getName(), "custom_name" => "lol", "alias" => "", "language" => Loader::getInstance()->getProvider()->getDefaultLanguage(), "skin" => " ", "coin" => 500]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.won_events", ["xuid" => $player->getXuid(), "name" => $player->getName(), "title" => "Enter the server for the first time", "description" => "an event for having entered for the first time, you win 500 coins", "prize" => "500"]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.points", ["xuid" => $player->getXuid(), "combo" => 1000, "gapple" => 1000, "nodebuff" => 1000, "trapping" => 1000, "bridge" => 1000, "classic" => 1000]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.kills", ["xuid" => $player->getXuid(), "combo" => 0, "gapple" => 0, "nodebuff" => 0, "trapping" => 0, "bridge" => 0, "classic" => 0]);
      Loader::getInstance()->getDatabase()->executeInsert("claude.murders", ["xuid" => $player->getXuid(), "combo" => 0, "gapple" => 0, "nodebuff" => 0, "trapping" => 0, "bridge" => 0, "classic" => 0]);
      $firstTimeServer = new DateTime("NOW");
      Loader::getInstance()->getDatabase()->executeInsert("claude.duration", ["xuid" => $player->getXuid(), "voted" => "0", "donated" => "0", "muted" => "0", "lastplayed" => "0", "totalonline" => "0", "time_join_server" => date_format($firstTimeServer, "Y-m-d-H-i"), "warnings" => 0]);
      $player->sendForm(new RulesForm());
    }
    $xuid = $player->getXuid();
    $session = $this->get($player->getName());
    Loader::getInstance()->getDatabase()->executeImplRaw([0 => "SELECT * FROM duration,murders,kills,points,won_events,user_data,settings WHERE duration.xuid = '$xuid' AND murders.xuid = '$xuid' AND kills.xuid = '$xuid' AND points.xuid = '$xuid' AND won_events.xuid = '$xuid' AND user_data.xuid = '$xuid' AND settings.xuid = '$xuid'"], [0 => []], [0 => SqlThread::MODE_SELECT], function(array $rows) use($session, $player) {
      if ($player instanceof Player) {
        var_dump($rows[0]->getRows()[0]); //test xd
        if (isset($rows[0], $rows[0]->getRows()[0]) && $player->getXuid() !== null) {
          $session->loadData($rows[0]->getRows[0]);
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