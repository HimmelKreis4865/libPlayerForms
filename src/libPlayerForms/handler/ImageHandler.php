<?php
declare(strict_types=1);
namespace libPlayerForms\handler;

use pocketmine\entity\Attribute;
use pocketmine\network\mcpe\protocol\NetworkStackLatencyPacket;
use pocketmine\network\mcpe\protocol\UpdateAttributesPacket;
use pocketmine\Player;
use pocketmine\scheduler\TaskHandler;
use function substr;

final class ImageHandler{

	/** @var \Closure[] */
	private static $callbacks = [];

	/**
	 * @param Player $player
	 * @return bool
	 */
	public static function silentUpdate(Player $player) : bool{
		$pk = new UpdateAttributesPacket();
		$pk->entityRuntimeId = $player->getId();
		$pk->entries[] = $player->getAttributeMap()->getAttribute(Attribute::EXPERIENCE_LEVEL);
		return $player->dataPacket($pk);
	}

	/**
	 * @param Player $player
	 * @param \Closure $callback
	 * @return bool
	 */
	public static function registerCallback(Player $player, \Closure $callback) : bool{
		$pk = new NetworkStackLatencyPacket();
		$pk->timestamp = $ts = (int) (substr((string) time(), 0, 7) . "000"); // hardcoded magic because the client does some weird stuff
		$pk->needResponse = true;
		if($player->dataPacket($pk) === false)
			return false;
		self::$callbacks[$id = $player->getId()][$ts] = $callback;
		return true;
	}

	/**
	 * @param Player $player
	 */
	public static function removeAllCallbacks(Player $player) : void{
		if(!isset(self::$callbacks[$id = $player->getId()]))
			return;
		unset(self::$callbacks[$id]);
	}

	/**
	 * @param Player $player
	 * @param int $timestamp
	 * @return bool
	 */
	public static function executeCallback(Player $player, int $timestamp) : bool{
		if(!isset(self::$callbacks[$id = $player->getId()][$ts = $timestamp]))
			return false;
		$callback = self::$callbacks[$id][$ts];
		$callback();
		unset(self::$callbacks[$id][$ts]);
		if(empty(self::$callbacks[$id]))
			self::removeAllCallbacks($player);
		return true;
	}

	/**
	 * @param \Closure $closure
	 * @param int $ticks
	 * @return TaskHandler
	 *
	public static function executeCallbackAfter(\Closure $closure, int $ticks) : TaskHandler{
		return HandlerManager::getPlugin()->getScheduler()->scheduleDelayedTask(new ClosureTask($closure), $ticks);
	}*/
	
}