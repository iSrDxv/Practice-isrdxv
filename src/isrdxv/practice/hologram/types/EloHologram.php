<?php

namespace isrdxv\practice\hologram\types;

use isrdxv\practice\hologram\Hologram;

class LeaderboardElo extends Hologram
{
  protected function place(bool $update = false): void;
}