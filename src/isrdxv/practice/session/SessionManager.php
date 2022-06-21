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
  
  public function set(string $username): void
  {
    if ($this->isSession($username)) {
      return;
    }
    $config = new Config(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR . $username . ".yml", Config::YAML);
    $config->set("name", $username);
    $config->set("points", 0);
    $config->set("murders", [
      "combo" => 0,
      "gapple" => 0,
      "nodebuff" => 0,
      "trapping" => 0
    ]);
    $config->set("deaths", [
      "combo" => 0,
      "gapple" => 0,
      "nodebuff" => 0,
      "trapping" => 0
    ]);
    $config->set("rank", "Player");
    $config->set("language", Loader::getInstance()->getProvider()->getDefaultLanguage());
    $config->set("won-events", []);
    $config->set("settings", ["score" => true, "queue" => false, "cps" => false, "auto-join" => false]);
    $config->save();
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
