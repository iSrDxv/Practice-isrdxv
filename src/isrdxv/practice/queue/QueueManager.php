<?php
//TODO: Terminar el sistema XD
namespace isrdxv\practice\queue;

use pocketmine\utils\SingletonTrait;

use isrdxv\practice\queue\Queue;

class QueueManager
{
  use SingletonTrait;
  
  private array $queues = [];
  
  public function create(): void;
  
  public function delete(): void;
  
  public function getQueueById(): ?Queue;
  
  public function getQueueByName(): ?Queue;
  
  public function getQueues(): array;
  
  public function getRandomInt(): int
  {
    return random_int(0, 999);
  }
  
  public function getRandomString(): string
  {
    return bin2hex(random_bytes(3));
  }
  
}