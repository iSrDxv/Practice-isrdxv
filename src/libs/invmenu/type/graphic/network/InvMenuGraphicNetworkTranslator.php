<?php

declare(strict_types=1);

namespace libs\invmenu\type\graphic\network;

use libs\invmenu\session\InvMenuInfo;
use libs\invmenu\session\PlayerSession;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;

interface InvMenuGraphicNetworkTranslator{

	public function translate(PlayerSession $session, InvMenuInfo $current, ContainerOpenPacket $packet) : void;
}