<?php
declare(strict_types=1);

namespace isrdxv\practice\kit;

use isrdxv\practice\kit\misc\Knockback;
use isrdxv\practice\kit\misc\ExtraDataEquipment;

interface Kit
{
  public const INVENTORY = "inventory";
  
  public const ARMOR = "armor";
  
  function __construct(string $name, string $localName, array $inventory = [], array $armor = [], ExtraDataEquipment $extraData, Knockback $knockback);
  
  function giveTo(): bool;
  
  function equals($kit): bool;
    
  function export(): array;
    
  function getName(): string;
  
  function getLocalName(): string;
  
  function getKnockback(): Knockback;
  
  function getExtraData(): ExtraDataEquipment;
}