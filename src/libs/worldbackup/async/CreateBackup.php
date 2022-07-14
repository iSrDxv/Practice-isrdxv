<?php

namespace libs\worldbackup\async;

use pocketmine\scheduler\AsyncTask;
use pocketmine\nbt\{
  TreeRoot,
  ReaderTracker,
  BigEndianNbtSerializer,
  tag\CompoundTag
};
use pocketmine\Server;

class CreateBackup extends AsyncTask
{
  private string $name;

  private string $destination;
  
  private string $source;
  
  private float $time;
  
  public function __construct(string $name, string $dest, string $source)
  {
    $this->name = $name;
    $this->destination = $dest;
    $this->source = $source;
    
    $this->time = microtime(true);
  }
  
  public function copyDirectory($dest, $source): void
  {
    if (is_dir($source)) {
      @mkdir($dest);
      $d = dir($source);
      while(FALSE !== ($entry = $d->read())) {
        if ($entry === "." or $entry === "..") {
          continue;
        }
        $newEntry = $source . DIRECTORY_SEPARATOR . $entry;
        if (is_dir($newEntry)) {
          $this->copyDirectory($dest . DIRECTORY_SEPARATOR . $entry, $newEntry);
          continue;
        }
        @copy($newEntry, $dest DIRECTORY_SEPARATOR . $entry);
      }
      $d->close();
    } else {
      @copy($source, $dest);
    }
  }
  
  public function onRun(): void
  {
    $this->copyDirectory($this->destination, $this->source);
    
    //Rename level.dat name
    $path = $this->destination . DIRECTORY_SEPARATOR . "level.dat";
    $serializer = new BigEndianNbtSerializer();
    $read = $serializer->read(file_get_contents($path));
    $tag = $read->getTag();
    /** CompoundTag|null **/
    $nbt = $tag->getCompoundTag("Data");
    if ($nbt instanceof CompoundTag) {
      $nbt->setString("LevelName", $this->name);
      file_put_contents($path, $serializer->write(new TreeRoot(CompoundTag::create()->setTag("", $nbt))));
      $this->setResult(true);
      return;
    }
    $this->setResult(false);
  }
  
  public function onCompletion(): void
  {
    if (is_dir($this->destination)) {
      if ($this->getResult()) {
        Server::getInstance()->getLogger()->info("§eCopied World: " . $this->name);
        Server::getInstance()->getLogger()->notice("§aI create the backup successfully in: " . $this->time - microtime(true) . " milliseconds");
      } else {
        Server::getInstance()->getLogger()->info("§eCopied World: " . $this->name);
        Server::getInstance()->getLogger()->warning("An error occurred while trying to copy the world on line 66, at a time of: " . $this->time - microtime(true) . " milliseconds");
      }
    }
  }
  
}