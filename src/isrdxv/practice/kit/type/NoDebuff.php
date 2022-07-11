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
    if ($sword instanceof Durable) {
      $item->setUnbreakable();
    }
    $this->addItem(parent::INVENTORY, $sword);
    $pearl = VanillaItems::ENDER_PEARL();
    $pearl->setCount(16);
    $this->addItem(parent::INVENTORY, $pearl);
    $steak = VanillaItems::STEAK();
    $steak->setCount(64);
    $this->addItem(parent::INVENTORY, $steak);
    $potion = ItemFactory::getInstance()->get(438, 22);
    $potion->setCount(36);
    $this->addItem(parent::INVENTORY, $potion);
  }
  
  public function setArmorItems(): void
  {
    foreach([VanillaItems::DIAMOND_HELMET(), VanillaItems::DIAMOND_CHESTPLATE(), VanillaItems::DIAMOND_LEGGINGS(), VanillaItems::DIAMOND_BOOTS()] as $item) {
      if ($item instanceof Durable) {
        $item->setUnbreakable();
      }
      $this->addItem(parent::ARMOR, $item);
      $this->addEnchantment($item, new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 1));
    }
  }

}
