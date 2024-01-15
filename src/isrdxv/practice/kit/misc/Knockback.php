<?php
declare(strict_types=1);

namespace isrdxv\practice\kit\misc;

use function is_array;

class Knockback
{
  
  private float|int $horizontalKb;
  
  private float|int $verticalKb;
  
  private float $maxHeight;
  
  private int $speed;
  
  private bool $canRevert;
  
  function __construct(float $kb = 0.5, float $vertKb = 0.5, float $height = 0.5, int $speed = 12, bool $revert = false)
  {
    $this->horizontalKb = $kb;
    $this->verticalKb = $vertKb;
    $this->maxHeight = $height;
    $this->speed = $speed;
    $this->canRevert = $revert;
  }
  
  function getHorizontal(): float|int
  {
    return $this->horizontalKb;
  }
  
  function getVertical(): float|int
  {
    return $this->verticalKb;
  }
  
  function getMaxHeight(): float
  {
    return $this->maxHeight;
  }
  
  function getSpeed(): int
  {
    return $this->speed;
  }
  
  function getCanRevert(): bool
  {
    return $this->canRevert;
  }

  function setHorizontal(float|int $value): float|int
  {
    $this->horizontalKb = $value;
  }
  
  function setVertical(float|int $value): float|int
  {
    $this->verticalKb = $value;
  }
  
  function setMaxHeight(float $value): float
  {
    $this->maxHeight = $value;
  }
  
  function setSpeed(int $value): int
  {
    $this->speed = $value;
  }
  
  function setCanRevert(bool $value): bool
  {
    $this->canRevert = $value;
  }
  
  function decode(array $data): self
  {
    if (is_array($data) && isset($data["hKB"], $data["vKB"], $data["height"], $data["speed"], $data["canRevert"])) {
      return new self($data["hKB"], $data["vKB"], $data["height"], $data["speed"], $data["canRevert"]);
    }
    return new self();
  }
  
  function export(): array
  {
    return ["hKB" => $this->horizontalKb, "vKB" => $this->verticalKb, "height" => $this->maxHeight, "speed" => $this->speed, "canRevert" => $this->canRevert];
  }
  
}