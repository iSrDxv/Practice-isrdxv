<?php

namespace isrdxv\practice\kit\type;

use pocketmine\item\{
  Item,
  ItemFactory,
  enchantment\VanillaEnchantments,
  VanillaItems,
  Durable,
  enchantment\EnchantmentInstance
};

use isrdxv\practice\kit\Kit;

class NoDebuff extends Kit
{
  
  public function __construct()
  {
    parent::__construct("nodebuff");
    $this->setItems();
    $this->setArmorItems();
  }
  
  public function setItems(): void
  {
    $sword = VanillaItems::DIAMOND_SWORD();
    $this->addEnchantment($sword, new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 1));
    $this->addEnchantment($sword, new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 5));
    if ($sword instanceof Durable) {
      $sword->setUnbreakable();
    }
    $this->addItem(parent::INVENTORY, $sword);
    $pearl = VanillaItems::ENDER_PEARL();
    $this->addItem(parent::INVENTORY, $pearl->setCount(16));
    for($i = 0; $i <= 6; $i++) {
      $this->addItem(parent::INVENTORY, ItemFactory::getInstance()->get(438, 22));
    }
    $steak = VanillaItems::STEAK();
    $this->addItem(parent::INVENTORY, $steak->setCount(64));
    for($i = 0; $i <= 30; $i++) {
      $this->addItem(parent::INVENTORY, ItemFactory::getInstance()->get(438, 22));
    }
  }
  
  public function setArmorItems(): void
  {
    foreach([VanillaItems::DIAMOND_HELMET(), VanillaItems::DIAMOND_CHESTPLATE(), VanillaItems::DIAMOND_LEGGINGS(), VanillaItems::DIAMOND_BOOTS()] as $item) {
      if ($item instanceof Durable) {
        $item->setUnbreakable();
      }
      $this->addItem(parent::ARMOR, $item);
      $this->addEnchantment($item, new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 5));
      $this->addEnchantment($item, new EnchantmentInstance(VanillaEnchantments::FIRE_PROTECTION(), 1));
    }
  }

}
