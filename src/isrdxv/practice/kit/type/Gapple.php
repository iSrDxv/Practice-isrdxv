<?php

namespace isrdxv\practice\kit\type;

use pocketmine\item\{
  Item,
  enchantment\VanillaEnchantments,
  VanillaItems,
  Durable,
  enchantment\EnchantmentInstance
};

use isrdxv\practice\kit\Kit;

class Gapple extends Kit
{
  
  public function __construct()
  {
    parent::__construct("gapple");
    $this->setItems();
    $this->setArmorItems();
  }
  
  public function setItems(): void
  {
    $sword = VanillaItems::IRON_SWORD();
    $this->addEnchantment($sword, new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
    if ($sword instanceof Durable) {
      $sword->setUnbreakable();
    }
    $this->addItem(parent::INVENTORY, $sword);
    $apple = VanillaItems::GOLDEN_APPLE();
    $this->addItem(parent::INVENTORY, $apple->setCount(16));
  }
  
  public function setArmorItems(): void
  {
    foreach([VanillaItems::IRON_HELMET(), VanillaItems::IRON_CHESTPLATE(), VanillaItems::IRON_LEGGINGS(), VanillaItems::IRON_BOOTS()] as $item) {
      if ($item instanceof Durable) {
        $item->setUnbreakable();
      }
      $this->addItem(parent::ARMOR, $item);
      $this->addEnchantment($item, new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 10));
    }
  }

}
