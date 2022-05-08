<?php

namespace isrdxv\practice\party;

use isrdxv\practice\party\Party;

class PartyManager 
{
  
  private array $parties = [];
  
  public function setParty(Party $party): void
  {
    $this->parties[$party->getName()] = $party;
  }
  
  public function getParty(): ?Party
  {
    return $this->parties[$party] ?? null;
  }
  
  public function isParty(): bool
  {
    return isset($this->parties[$party]);
  }
  
  public function getTotalParties(): int
  {
    return count($this->parties);
  }
  
}
