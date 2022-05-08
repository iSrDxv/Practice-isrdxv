<?php

declare(strict_types=1);

namespace libs\invmenu\session;

use libs\invmenu\InvMenu;
use libs\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		public InvMenu $menu,
		public InvMenuGraphic $graphic
	){}
}
