<?php
declare(strict_types=1);

namespace isrdxv\practice\kit;

use isrdxv\practice\kit\Kit;
use isrdxv\practice\kit\misc\Knockback;
use isrdxv\practice\kit\misc\ExtraDataEquipment;

use pocketmine\item\{
  Item,
  enchantment\EnchantmentInstance,
};

class DefaultKit implements Kit
{
  /** 
   * @var String
   * The name of kit (custom name)
  */
  private string $name;
  /**
   * @var String
   * The name of kit (first name, not custom)
  */
  private string $localName;
  /** @var Item[] **/
  private array $inventory = [];
  /** @var Item[] **/
  private array $armor = [];
  /** @export array **/
  private ExtraDataEquipment $extraData;
  
  private Knockback $knockback;
  /** @var EffectInstance[] **/
  private array $effects = [];
  
  public function __construct(string $name, string $localName, array $inventory = [], array $armor = [], ExtraDataEquipment $extraData, Knockback $knockback)
  {
    $this->name = $name;
    $this->localName = $localName;
    $this->inventory = $inventory;
    $this->armor = $armor;
    $this->extraData = $extraData;
    $this->knockback = $knockback;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getLocalName(): string
  {
    return $this->localName;
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
  
  public function addEnchantment(Item $item, array|EnchantmentInstance $enchantments = null): void
  {
    if ($enchantments !== null) {
      if (!is_array($enchantments)) {
        $item->addEnchantment($enchantments);
        return;
      }
      foreach($enchantments as $enchantment) {
        $item->addEnchantment($enchantment);
      }
    }
  }
  
}