<?php
//TODO: Terminar el sistema XD
namespace isrdxv\practice\queue;

use pocketmine\utils\SingletonTrait;

use isrdxv\practice\queue\Queue;

class QueueManager
{
  use SingletonTrait;
  
  private array $queues = [];
  
  /*public function create(): void;
  
  public function delete(): void;*/
  
  public function getQueueById(int $id): ?Queue
  {
    $class = null;
    foreach($this->queues as $queue) {
      if ($queue instanceof Queue) {
        if ($queue->getId() === $id) {
        $class = $queue;
        }
      }
    }
    return $class;
  }
  
  public function getQueueByName(string $arena_name): ?Queue
  {
    $class = null;
    foreach($this->queues as $queue) {
      if ($queue instanceof Queue) {
        if ($queue->getArena()->getName() === $arena_name) {
        $class = $queue;
        }
      }
    }
    return $class;
  }
  
  public function getQueues(): array
  {
    return $this->queues;
  }
  
  public function getRandomInt(): int
  {
    return random_int(0, 999);
  }
  
  public function getRandomString(): string
  {
    return bin2hex(random_bytes(3));
  }
  
}
