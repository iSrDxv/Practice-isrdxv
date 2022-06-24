<?php

namespace isrdxv\practice\queue;

use isrdxv\practice\queue\Queue;
use isrdxv\practice\arena\ArenaManager;

class QueueManager
{
  private array $queues = [];
  
  public function __construct()
  {
    $id = bin2hex(random_bytes(3));
    //NoDebuff
    $this->create(new Queue($id, "NoDebuff", ArenaManager::TYPE_DUEL));
    $this->create(new Queue($id, "NoDebuff", ArenaManager::TYPE_FFA));
    
    //Gapple
    $this->create(new Queue($id, "Gapple", ArenaManager::TYPE_DUEL));
    $this->create(new Queue($id, "Gapple", ArenaManager::TYPE_FFA));
    
    //Combo
    $this->create(new Queue($id, "Combo", ArenaManager::TYPE_DUEL));
    $this->create(new Queue($id, "Combo", ArenaManager::TYPE_FFA));
  }
  
  public function create(Queue $queue): void
  {
    $this->queues[$queue->getId()] = $queue;
  }
  
  public function delete(string $id): void
  {
    if (isset($queue = $this->queues[$id])) {
      unset($queue);
    }
  }
  
  public function getQueueById(string $id): ?Queue
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
  
  public function getQueueCount(): int
  {
    $count = 0;
    foreach($this->queues as $queue) {
      if (count($queue->getPlayers()) === 2) {
        $count++;
      }
    }
    return $count;
  }
  
}