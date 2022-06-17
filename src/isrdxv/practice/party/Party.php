<?php

namespace isrdxv\practice\party;

use isrdxv\practice\session\Session;

class Party
{
  
  private string $name;
  
  private string $customName;
  
  private Session $leader;
 
  private array $members = [];
  
  private int $slots = 10;
  
  public function __construct(string $name, Session $session)
  {
    $this->name = $name;
    $this->customName = $name . "'s ";
    $this->leader = $session;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getLeader(): Session
  {
    return $this->leader;
  }
  
  public function getSlots(): int
  {
    return $this->slots;
  }
  
  public function getMembers(): array
  {
    return $this->members;
  }
  
  public function getCountMembers(): int
  {
    return count($this->members);
  }
  
  public function isFull(): bool
  {
    return ($this->getCountMembers() >= $this->getSlots());
  }
  
  public function setSlots(int $slot): void
  {
    $this->slots = ($slot === null) ? $this->slots : $slot;
  }
  
  public function set(Session $session): void
  {
    $this->members[] = $session;
    $session->setParty($this);
    $this->sendMembers("has joined the party");
  }
  
  public function unset(Session $session): void
  {
    if ($this->isMember($session)) {
      //unset();
    }
    $session->setParty(null);
    $this->sendMembers("has left the party!");
  }
  
  public function sendMembers(string $message): void
  {
    foreach($this->getMembers() as $member) {
      $member->getPlayer()->sendMessage($message);
    }
  }
  
}
