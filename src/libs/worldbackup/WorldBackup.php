<?php

namespace libs\worldbackup;

use libs\worldbackup\async\CreateBackup;
use libs\worldbackup\async\DeleteBackup;

use pocketmine\Server;

final class WorldBackup
{
  
  public function createBackup(string $newName, string $worldName): bool
  {
    $worldManager = Server::getInstance()->getWorldManager();
    if ($worldManager->isWorldGenerated($newName)) {
      return false;
    }
    if (!$worldManager->isWorldGenerated($worldName)) {
      return false;
    }
    if (!$worldManager->isWorldLoaded($worldName)) {
      //exception
      return false;
    }
    $destination = Server::getInstance()->getDataPath() . DIRECTORY_SEPARATOR . $newName;
    $source = Server::getInstance()->getDataPath() . DIRECTORY_SEPARATOR . $worldName;
    Server::getInstance()->getAsyncPool()->submitTask(new CreateBackup($newName, $destination, $source));
    return true;
  }
  
  public function deleteBackup(string $directory): bool
  {
    if (!is_dir($directory)) {
      return false;
    }
    Server::getInstance()->getAsyncPool()->submitTask(new DeleteBackup($directory));
    return true;
  }
  
}