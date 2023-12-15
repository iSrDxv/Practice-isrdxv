<?php

namespace isrdxv\practice\utils;

use function gmdate;

class Time
{
  
  public static function getTimeToSeconds(int $time): int
  {
    return gmdate("i:s", $time);
  }
  
  public static function getTimeToHours(int $time): int
  {
    return gmdate("H:i:s", $time);
  }
  
  public static function secondsToTicks(int $time): int
  {
    return ($time * 20);
  }
  
  public static function minutesToTicks(int $time): int
  {
    return ($time * 1200);
  }

  public static function hoursToTicks(int $time): int
  {
    return ($time * 72000);
  }
  
  public static function getTimeFull(int $time): string
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