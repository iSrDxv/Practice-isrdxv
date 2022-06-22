<?php

namespace isrdxv\practice\queue;

use isrdxv\practice\queue\Queue;
use isrdxv\practice\arena\ArenaManager;

class QueueManager
{
  private array $queues = [];
  
  public function __construct()
  {
    //NoDebuff
    $this->create(new Queue($this->getRandomInt(), "NoDebuff", ArenaManager::TYPE_DUEL));
    $this->create(new Queue($this->getRandomInt(), "NoDebuff", ArenaManager::TYPE_FFA));
    
    //Gapple
    $this->create(new Queue($this->getRandomInt(), "Gapple", ArenaManager::TYPE_DUEL));
    $this->create(new Queue($this->getRandomInt(), "Gapple", ArenaManager::TYPE_FFA));
    
    //Combo
    $this->create(new Queue($this->getRandomInt(), "Combo", ArenaManager::TYPE_DUEL));
    $this->create(new Queue($this->getRandomInt(), "Combo", ArenaManager::TYPE_FFA));
  }
  
  public function create(Queue $queue): void
  {
    $this->queues[$queue->getId()] = $queue;
  }
  
  public function delete(int $id): void
  {
    if (isset($queue = $this->queues[$id])) {
      unset($queue);
    }
  }
  
  public function getQueueById(int $id): ?Queue
  {
    $class = null;
    foreach($this->queues as $queue) {
        if ($queue->getId() === $id) {
        $class = $queue;
        }
    }
    return $class;
  }
  
  public function getQueueByName(string $arena_name): ?Queue
  {
    $class = null;
    foreach($this->queues as $queue) {
        if ($queue->getArena()->getName() === $arena_name) {
        $class = $queue;
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
