<?php

namespace isrdxv\practice\utils;

use function gmdate;

class Utils
{
  
  public function getTimeToSeconds(int $time): int
  {
    return gmdate("i:s", $time);
  }
  
  public function getTimeToHours(int $time): int
  {
    return gmdate("H:i:s", $time);
  }
  
}