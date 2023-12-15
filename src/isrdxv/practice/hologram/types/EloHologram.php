<?php

namespace isrdxv\practice\entity\types;

use isrdxv\practice\entity\Hologram;

class LeaderboardElo extends Hologram
{
  protected function place(bool $update = false): void;
}