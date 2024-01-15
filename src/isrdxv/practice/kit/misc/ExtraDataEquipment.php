<?php
declare(strict_types=1);

namespace isrdxv\practice\kit\misc;

use isrdxv\practice\kit\misc\Knockback;

use pocketmine\Server;

class ExtraDataEquipment
{
  private string $icon = ""; //url o texture name
  
  private bool $canBuild = false;
  
  private ?Knockback $knockback = null;
  
  function __construct(string $icon = "", bool $canBuild = false, ?Knockback $knockback = null)
  {
    $this->icon = $icon;
    $this->canBuild = $canBuild;
    $this->knockback = ($knockback !== null ? $knockback : new Knockback());
  }
  
  static function create(array $data): self
  {
    if (is_array($data) && isset($data["canBuild"], $data["icon"])) {
      return new self($data);
    }
  }
  
  function export(): array
  {
    return [];
  }
  
  function setBuild(bool $value): void
  {
    $this->canBuild = $value;
  }
  
  function canBuild(): bool
  {
    return $this->canBuild;
  }
  
  function setIcon(string $icon = ""): void
  {
    $this->icon = $icon;
  }
  
  function hasIcon(): bool
  {
    return $this->icon !== "";
  }
  
  function getIcon(): string
  {
    return $this->icon;
  }
  
}