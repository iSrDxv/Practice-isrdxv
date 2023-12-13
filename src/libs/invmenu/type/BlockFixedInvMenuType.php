<?php

declare(strict_types=1);

namespace libs\invmenu\type;

use libs\invmenu\inventory\InvMenuInventory;
use libs\invmenu\InvMenu;
use libs\invmenu\type\graphic\BlockInvMenuGraphic;
use libs\invmenu\type\graphic\InvMenuGraphic;
use libs\invmenu\type\graphic\network\InvMenuGraphicNetworkTranslator;
use libs\invmenu\type\util\InvMenuTypeHelper;
use libs\invmenu\type\FixedInvMenuType;
use pocketmine\block\Block;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;
use pocketmine\world\World;

final class BlockFixedInvMenuType implements FixedInvMenuType{

	public function __construct(
		private Block $block,
		private int $size,
		private ?InvMenuGraphicNetworkTranslator $network_translator = null
	){}

	public function getSize() : int{
		return $this->size;
	}

	public function createGraphic(InvMenu $menu, Player $player) : ?InvMenuGraphic{
		$origin = $player->getPosition()->addVector(InvMenuTypeHelper::getBehindPositionOffset($player))->floor();
		if($origin->y < World::Y_MIN || $origin->y >= World::Y_MAX){
			return null;
		}

		return new BlockInvMenuGraphic($this->block, $origin, $this->network_translator);
	}

	public function createInventory() : Inventory{
		return new InvMenuInventory($this->size);
	}
}
