<?php

namespace isrdxv\practice\utils;

use pocketmine\utils\TextFormat;

class Utilities
{
  
  public const PLUGIN_PREFIX = TextFormat::BOLD . TextFormat::BLACK . "[" . TextFormat::ITALIC . TextFormat::AQUA . "Practice" . TextFormat::RESET . TextFormat::BOLD . TextFormat::BLACK . "] ";
  
  public static function getModeToString(string $mode): String
  {
    switch(strtolower($mode)){
    case "nodebuff":
      $mode = "NoDebuff";
    break;
    case "combo":
      $mode = "ComboFly";
    break;
    case "gapple":
      $mode = "Gapple";
    break;
    case "trapping":
      $mode = "Trapping";
    break;
    }
    return $mode;
  }
  
}
