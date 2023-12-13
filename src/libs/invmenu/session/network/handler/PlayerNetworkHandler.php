<?php

declare(strict_types=1);

namespace libs\invmenu\session\network\handler;

use Closure;
use libs\invmenu\session\network\NetworkStackLatencyEntry;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}
