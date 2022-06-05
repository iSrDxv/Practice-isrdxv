<?php

namespace isrdxv\practice\utils;

use function gmdate;

class Time
{
  
  public function getTimeToSeconds(int $time): int
  {
    return gmdate("i:s", $time);
  }
  
  public function getTimeToHours(int $time): int
  {
    return gmdate("H:i:s", $time);
  }
  
  public function getTimeFull(int $time): string
  {
    $time = $time - time();
    $seconds = $time % 60;
    
    $minutes = null;
    $hours = null;
    $days = null;
    
    if ($time >= 60) {
      $minutes = floor(($time % 3600) / 60);
      if ($time >= 3600) {
        $hours = floor(($time % 86400) / 3600);
        if ($time >= 3600 * 24) {
          $days = floor($time / 86400);
        }
      }
    }
    return ($minutes !== null ? ($hours !== null ? ($days !== null ? "$days days" : "") . "$hours hours" : "") . "$minutes minutes" : "") . "$seconds seconds";
  }
  
}
