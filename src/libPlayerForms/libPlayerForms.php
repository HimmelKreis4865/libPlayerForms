<?php
declare(strict_types=1);
namespace libPlayerForms;

use libPlayerForms\form\ServerSettingsForm;
use pocketmine\form\Form;
use pocketmine\Player;
use function array_pop;
use function array_shift;
use function array_slice;
use function count;

final class libPlayerForms{

	/** @var ServerSettingsForm|null */
	private static $serverSettingsForm;

	/**
	 * @return ServerSettingsForm|null
	 */
	public static function getServerSettingsForm() : ?ServerSettingsForm{
		return self::$serverSettingsForm;
	}

	/**
	 * @param ServerSettingsForm|null $serverSettingsForm
	 */
	public static function setServerSettingsForm(?ServerSettingsForm $serverSettingsForm) : void{
		self::$serverSettingsForm = $serverSettingsForm;
	}

	/**
	 * @param Player $player
	 * @return Form[]
	 * @throws \ReflectionException
	 */
	public static function getFormsOf(Player $player) : array{
		$forms = (new \ReflectionClass(Player::class))->getProperty("forms");
		$forms->setAccessible(true);
		return $forms->getValue($player);
	}

	/**
	 * @param Player $player
	 * @return Form|null
	 * @throws \ReflectionException
	 */
	public static function getCurrentFormOf(Player $player) : ?Form{
		$forms = self::getFormsOf($player);
		return array_pop($forms);
	}

	/**
	 * @param Player $player
	 * @return array
	 * @throws \ReflectionException
	 */
	public static function getPendingFormsOf(Player $player) : array{
		if(count(self::getFormsOf($player)) <= 1)
			return [];
		return array_slice(self::getFormsOf($player), 0, -1);
	}

}