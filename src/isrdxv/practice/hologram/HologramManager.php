<?php
declare(strict_types=1);

namespace isrdxv\practice\hologram;

use isrdxv\practice\Loader;
use isrdv\practice\hologram\types\{
  HologramElo,
};
use isrdv\practice\hologram\task\{
  UpdateHologramTask,
  LoadHologramContentTask
};
use isrdxv\practice\arena\mode\ModeType;

use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\utils\{
  Config,
  SingletonTrait
};

class HologramManager
{
  use SingletonTrait;
  
  private string $path;
  
  private Config $hologram;
  
  private array $content = [];
  
  //Holograms
  private Hologram $elo;
  
  private Hologram $kdr;
  
  private Hologram $kills;
  
  private Hologram $rules;
  
  public function init(): void
  {
    self::setInstance($this);
    $this->hologram = new Config(($this->path = Loader::getInstance()->getDataFolder() . "hologram.json"), Config::JSON, []);
    if (file_exists($this->path)) {
      $holograms = $this->hologram->getAll(true);
      foreach($holograms as $hologram) {
        $data = $this->hologram->get($hologram);
        if (isset($data["world"], $data["x"], $data["y"], $data["z"]) && ($world = Server::getInstance()->getWorldManager()->getWorldByName($data["world"]))) {
          switch($hologram){
            case "elo":
              $this->elo = new EloHologram(new Vector3($data["x"], $data["y"], $data["z"]), $world);
            break;
            case "kills":
              $this->kills = new KillsHologram(new Vector3($data["x"], $data["y"], $data["z"]), $world);
            break;
            case "kdr";
              $this->kdr = new KDRHologram(new Vector3($data["x"], $data["y"], $data["z"]), $world);
            break;
            case "rules":
              $this->rules = new RulesHologram(new Vector3($data["x"], $data["y"], $data["z"]), $world);
            break;
          }
        }
      }
      (new UpdateHologramTask());
      (new LoadHologramContent());
    } else {
      $this->hologram->save();
    }
  }
  
  private function getKeys(bool $elo = true): array
  {
    if ($elo) {
      return ModeType::MODES_LIST;
    }
    return ["kills", "kdr"];
  }
  
  public function updateHolograms(): void
  {
    $this->kills?->update();
    $this->elo?->update();
    $this->kdr?->update();
    $this->rules?->update();
  }
  
  public function loadHologramsContent(): void
  {
    
  }
  
}