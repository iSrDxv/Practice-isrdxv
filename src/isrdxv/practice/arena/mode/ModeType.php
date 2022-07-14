<?php

namespace isrdxv\practice\arena\mode;

class ModeType
{
  
  public const COMBO = "combo";
  
  public const GAPPLE = "gapple";
  
  public const NO_DEBUFF = "nodebuff";
  
  public const SUMO = "sumo";
  
  public const ARCHER = "archer";
  
  public const BUILD_UHC = "builduhc";
  
  public const MODES_LIST = [
    self::COMBO,
    self::GAPPLE,
    self::NO_DEBUFF,
    self::SUMO,
    self::ARCHER,
    self::BUILD_UHC
  ];
  
}
