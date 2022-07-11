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

class Combo extends Kit
{
  
  public function __construct()
  {
    parent::__construct("combo");
    $this->setItems();
    $this->setArmorItems();
  }
  
  public function setItems(): void
  {
    $sword = VanillaItems::DIAMOND_SWORD();
    $this->addEnchantment($sword, new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
    if ($sword instanceof Durable) {
      $sword->setUnbreakable();
    }
    $this->addItem(parent::INVENTORY, $sword);
    $pearl = VanillaItems::ENDER_PEARL();
    $this->addItem(parent::INVENTORY, $pearl->setCount(5));
    $apple = VanillaItems::GOLDEN_APPLE();
    $this->addItem(parent::INVENTORY, $apple->setCount(32));
    foreach([VanillaItems::DIAMOND_HELMET(), VanillaItems::DIAMOND_CHESTPLATE(), VanillaItems::DIAMOND_LEGGINGS(), VanillaItems::DIAMOND_BOOTS()] as $item) {
      $this->addEnchantment($item, new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 10));
      if ($item instanceof Durable) {
        $item->setUnbreakable();
      }
      $this->addItem(parent::INVENTORY, $item);
    }
  }
  
  public function setArmorItems(): void
  {
    foreach([VanillaItems::DIAMOND_HELMET(), VanillaItems::DIAMOND_CHESTPLATE(), VanillaItems::DIAMOND_LEGGINGS(), VanillaItems::DIAMOND_BOOTS()] as $item) {
      if ($item instanceof Durable) {
        $item->setUnbreakable();
      }
      $this->addItem(parent::ARMOR, $item);
      $this->addEnchantment($item, new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 10));
    }
  }

}
