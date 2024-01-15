<?php
declare(strict_types=1);

namespace isrdxv\practice\server;

class ServerPractice
{
  private string $address;
  
  private int $port;
  
  function __construct(string $address, int $port = 19132)
  {
    $this->address = $address;
    $this->port = $port;
  }
  
  function getAddress(): string|int
  {
    return is_string($this->address) ? $this->address : intval($this->address);
  }
  
  function getPort(): int
  {
    return is_string($this->port) ? intval($this->port) : $this->port;
  }
  
  function update(): void
  {
    
  }
  
}