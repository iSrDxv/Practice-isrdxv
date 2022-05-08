<?php

namespace isrdxv\practice\kit;

use pocketmine\item\{
  Item,
  enchantment\EnchantmentInstance,
};

class Kit
{
  public const INVENTORY = "inventory";
  public const ARMOR = "armor";
  
  /** @var String **/
  private string $name;
  /** @var Item[] **/
  private array $inventory = [];
  /** @var Item[] **/
  private array $armor = [];
  
  public function __construct(string $name)
  {
    $this->name = $name;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getInventoryItems(): array
  {
    return $this->inventory;
  }
  
  public function getArmorItems(): array
  {
    return $this->armor;
  }
  
  public function addItem(string $type, Item $item): void
  {
    switch(strtolower($type)){
      case self::INVENTORY:
        $this->inventory[] = $item;
      break;
      case self::ARMOR:
        $this->armor[] = $item;
      break;
    }
  }
  
  public function addEnchantment(Item $item, array $enchantments = null): void
  {
    if ($enchantments !== null) {
      if (!is_array($enchantments)) {
        $item->addEnchantment($enchantments);
      }
      foreach($enchantments as $enchantment) {
        $item->addEnchantment($enchantment);
      }
    }
  }
  
}