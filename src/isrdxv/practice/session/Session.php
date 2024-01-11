<?php
declare(strict_types=1);

namespace isrdxv\practice\session;

use pocketmine\utils\TextFormat;
use pocketmine\player\{
  Player,
  GameMode
};
use pocketmine\Server;
use pocketmine\permission\{
  Permission,
  PermissionManager
};
use pocketmine\item\{
  Item,
  ItemTypeIds,
  VanillaItems
};

use isrdxv\practice\Loader;
use isrdxv\practice\translation\TranslationMessage;
use isrdxv\practice\provider\YAMLProvider;
use isrdxv\practice\queue\Queue;
use isrdxv\practice\game\Game;
use isrdxv\practice\kit\Kit;

use libs\scoreboard\type\LobbyScoreboard;
use libs\scoreboard\Scoreboard;

class Session
{
  
  private Player $player;
  
  private ?string $name;
  
  private ?string $custom_name;
  
  private string $rank;
  
  private string $language;
  
  private string $device;
  
  private string $control;

  /** @var Scoreboard|null **/
  private ?Scoreboard $scoreboard;
  
  /** @var Queue|null **/
  private ?Queue $queue = null;
  
  private ?Game $game = null;
  
  private Kit $kit;
  
  private array $settings;
  
  private array $kills;
  
  private array $deaths;
  
  private array $wonEvents;
  
  private int $elo;
  
  public function __construct(Player $player) 
  {
    $this->player = $player;
    $this->scoreboard = new LobbyScoreboard($player);
    // String
    //$this->rank = Loader::getInstance()->getRankManager()->getRankByName($player->getName());
  }
  
  public function getPlayer(): Player
  {
    return $this->player;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getPing(): int
  {
    return $this->player->getNetworkSession()->getPing();
  }
  
  public function getDevice(): string
  {
    return $this->device;
  }
  
  public function getScoreboard(): Scoreboard
  {
    return $this->scoreboard;
  }
  
  public function isScoreboard(): bool
  {
    return isset($this->scoreboard);
  }
  
  public function setScoreboard(Scoreboard $scoreboard): void
  {
    if (!$this->getPlayer()->isOnline()) {
      return;
    }
    $this->scoreboard = $scoreboard;
    $scoreboard->show();
    $scoreboard->showLines();
  }
  
  public function changeScoreboard(): void
  {
    if ($this->getSetting("score") === false) {
      $this->getScoreboard()->remove();
      return;
    }
    $this->setScoreboard($this->scoreboard);
  }
  
  public function getQueue(): ?Queue
  {
    return $this->queue ?? null;
  }
  
  public function hasQueue(): bool
  {
    return isset($this->queue);
  }
  
  public function setQueue(?Queue $queue = null): void
  {
    $this->queue = $queue;
  }
  
  public function getGame(): ?Game
  {
    return $this->game ?? null;
  }
  
  public function isGame(): bool
  {
    return isset($this->game);
  }
  
  public function setGame(?Game $game = null): void
  {
    $this->game = $game;
  }
  
  public function getSettings(): array
  {
    return $this->settings;
  }
  
  public function getSetting(string $setting): bool
  {
    return $this->settings[$setting];
  }
  
  public function setSetting(string $setting, bool $value = false): void
  {
    $this->settings[$setting] = $value;
  }
  
  public function setSettings(array $data): void
  {
    $this->settings = $data;
  }
  
  public function getPoints(): int
  {
    return $this->elo;
  }
  
  public function addPoint(int $amount = 0): void
  {
    $this->elo += $amount;
  }
  
  public function subtractPoint(int $amount= 0): void
  {
    $this->elo -= $amount;
  }
  
  public function getMurders(): array
  {
    return $this->kills;
  }
  
  public function getDeaths(): array
  {
    return $this->deaths;
  }
  
  public function getWonEvents(): array
  {
    return $this->wonEvents;
  }
  
  public function setLanguage(string $language): void
  {
    $this->language = $language;
  }
  
  public function getLanguage(): string
  {
    return $this->language;
  }
  
  public function isPlaying(): bool
  {
    if ($this->isGame()) {
      return $this->getGame()->isPlaying($this);
    }
    return false;
  }
  
  public function setKit(Kit $kit): void
  {
    $this->kit = $kit;
    //add items
    $this->getPlayer()->getInventory()->setContents($kit->getInventoryItems());
    $this->getPlayer()->getArmorInventory()->setContents($kit->getArmorItems());
  }
  
  public function sendMessage(TranslationMessage|string $message): void
  {
    if ($message instanceof TranslationMessage) {
      $message = Loader::getInstance()->getTranslation()->sendTranslation($this->getLanguage(), $message->getText(), $message->getParameters());
    }
    $this->getPlayer()->sendMessage(TextFormat::colorize($message));
  }
  
  public function setGamemode(int $value): void
  {
    switch($value){
      case 0:
        $this->player->setGamemode(GameMode::SURVIVAL());
      break;
      case 1:
        $this->player->setGamemode(GameMode::CREATIVE());
      break;
      case 2:
        $this->player->setGamemode(GameMode::ADVENTURE());
      break;
      case 3:
        $this->player->setGamemode(GameMode::SPECTATOR());
      break;
      default:
        $this->player->setGamemode(GameMode::ADVENTURE());
      break;
    }
  }
  
  public function loadData(array $data): void
  {
    $this->settings = [
      "cps" => (bool)$data["cps"],
      "score" => (bool)$data["scoreboard"],
      "queue" => (bool)$data["queue"],
      "auto-join" => (bool)$data["auto_join"]
    ];
    $this->kills = [
      "combo" => $data["combo"],
      "gapple" => $data["gapple"],
      "nodebuff" => $data["nodebuff"],
      "trapping" => $data["trapping"],
      "bridge" => $data["bridge"],
      "classic" => $data["classic"]
    ];
    $this->deaths = [
      "combo" => $data["combo1"],
      "gapple" => $data["gapple1"],
      "nodebuff" => $data["nodebuff1"],
      "trapping" => $data["trapping1"],
      "bridge" => $data["bridge1"],
      "classic" => $data["classic1"]
    ];
    $this->wonEvents = array(
      "title" => $data["title"], "description" => $data["description"], "prize" => $data["prize"]
    );
    var_dump($this->wonEvents); //to see what the array is like, and what steps I should follow.
    $this->elo = $data["points"];
    $this->name = is_string($data["name"]) ? $data["name"] : "unknown";
    $this->custom_name = is_string($data["custom_name"]) ? $data["custom_name"] : null;
    $this->alias = $data["alias"];
    $this->language = $data["language"];
    /*$this->coin = $data["coin"];
    $this->wins = $data["wins"];*/
    $player = $this->getPlayer();
    $name = $this->custom_name !== null ? $this->custom_name : $this->name;
    $player->setNameTag(TextFormat::AQUA . $name);
    $this->device = $data["device"];
    $this->control = $data["control"];
    $player->setScoreTag($this->device . " | " . $this->control);
  }
  
  /**
   * I'm lazy to shorten the item code
   **/
  public function giveLobbyItems(): void
  {
    $ranked = VanillaItems::DIAMOND_SWORD();
    $unranked = VanillaItems::IRON_SWORD();
    $ffa = VanillaItems::STONE_AXE();
    $party = VanillaItems::TOTEM();
    $profile = VanillaItems::BOOK();
    $ranked->setCustomName(TextFormat::colorize("&l&fRanked &cQueue"));
    $unranked->setCustomName(TextFormat::colorize("&l&fUnRanked &cQueue"));
    $ffa->setCustomName(TextFormat::colorize("&l&fFFA &cQueue"));
    $party->setCustomName(TextFormat::colorize("&l&fParty"));
    $profile->setCustomName(TextFormat::colorize("&l&fSettings"));
    $this->getPlayer()->getInventory()->clearAll();
    $this->getPlayer()->getArmorInventory()->clearAll();
    $this->getPlayer()->getInventory()->setItem(0, $ranked);
    $this->getPlayer()->getInventory()->setItem(1, $unranked);
    $this->getPlayer()->getInventory()->setItem(2, $ffa);
    $this->getPlayer()->getInventory()->setItem(4, $party);
    $this->getPlayer()->getInventory()->setItem(8, $profile);
  }
  
  public function giveQueueItems(): void
  {
    $leave = VanillaItems::COMPASS();
    $leave->setCustomName(TextFormat::colorize("&l&o&fLeave Queue"));
    $this->getPlayer()->getInventory()->clearAll();
    $this->getPlayer()->getArmorInventory()->clearAll();
    $this->getPlayer()->getInventory()->setItem(4, $leave);
  }
  
  public function teleportToLobby(): void
  {
    $world = Server::getInstance()->getWorldManager()->getWorldByName(Loader::getInstance()->getConfig()->get("lobby-name"));
    $this->player->teleport($world->getSafeSpawn());
    $this->player->setHealth($this->player->getMaxhealth());
  }
  
  public function addPermission(string $permission = "", string $description = null): void
  {
    if ($permission !== "") {
      $permission = new Permission($permission, $description);
    }
    PermissionManager::getInstance()->addPermission($permission);
  }
  
  public function saveData(): void
  {
    $database = Loader::getInstance()->getDatabase();
    $database->executeImplRaw([0 => "UPDATE deaths SET combo1='$this->deaths['combo']', gapple1='$this->deaths['gapple'], nodebuff1='$this->deaths['nodebuff'], trapping1='$this->deaths['trapping'], bridge1='$this->deaths['bridge'], classic1='$this->deaths['classic']' WHERE xuid='$this->getPlayer()->getXuid()'"], [0 => []], [0 => SqlThread::MODE_CHANGE], function(int $affectedRows): void {});
    $database->executeImplRaw([0 => "UPDATE murders SET combo='$this->deaths['combo']', gapple='$this->deaths['gapple'], nodebuff='$this->deaths['nodebuff'], trapping='$this->deaths['trapping'], bridge='$this->deaths['bridge'], classic='$this->deaths['classic']' WHERE xuid='$this->getPlayer()->getXuid()'"], [0 => []], [0 => SqlThread::MODE_CHANGE], function(int $affectedRows): void {});
  }
  
}