<?php

namespace isrdxv\practice\queue;

use isrdxv\practice\queue\Queue;
use isrdxv\practice\arena\ArenaManager;
use isrdxv\practice\utils\Utilities;

class QueueManager
{
  private array $queues = [];
  
  public function __construct()
  {
    //NoDebuff
    $this->create(new Queue(Utilities::getRandomBin(), "NoDebuff", ArenaManager::TYPE_DUEL, true));
    $this->create(new Queue(Utilities::getRandomBin(), "NoDebuff", ArenaManager::TYPE_DUEL));
    $this->create(new Queue(Utilities::getRandomBin(), "NoDebuff", ArenaManager::TYPE_FFA));
    
    //Gapple
    $this->create(new Queue(Utilities::getRandomBin(), "Gapple", ArenaManager::TYPE_DUEL, true));
    $this->create(new Queue(Utilities::getRandomBin(), "Gapple", ArenaManager::TYPE_DUEL));
    $this->create(new Queue(Utilities::getRandomBin(), "Gapple", ArenaManager::TYPE_FFA));
    
    //Combo
    $this->create(new Queue(Utilities::getRandomBin(), "Combo", ArenaManager::TYPE_DUEL, true));
    $this->create(new Queue(Utilities::getRandomBin(), "Combo", ArenaManager::TYPE_DUEL));
    $this->create(new Queue(Utilities::getRandomBin(), "Combo", ArenaManager::TYPE_FFA));
  }
  
  public function create(Queue $queue): void
  {
    $this->queues[$queue->getId()] = $queue;
  }
  
  public function delete(string $id): void
  {
    if (!empty($queue = $this->queues[$id])) {
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
      if (count($queue->getPlayers()) > 0) {
        ++$count;
      }
    }
    return $count;
  }
  
}
