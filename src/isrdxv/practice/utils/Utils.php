<?php

namespace isrdxv\practice\utils;

class Utils 
{
  
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
