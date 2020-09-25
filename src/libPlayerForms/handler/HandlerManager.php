<?php
declare(strict_types=1);
namespace libPlayerForms\handler;

use pocketmine\plugin\Plugin;

final class HandlerManager{

	/** @var Plugin */
	private static $plugin;

	/**
	 * @return bool returns true if the handler is already registered
	 */
	public static function isRegistered() : bool{
		return self::$plugin !== null;
	}

	/**
	 * @param Plugin $plugin the plugin where the eventhandler gets registered on
	 * @return bool returns true if the registration was successful
	 */
	public static function register(Plugin $plugin) : bool{
		if(self::isRegistered())
			return false;
		if(!$plugin->isEnabled())
			return false;
		$plugin->getServer()->getPluginManager()->registerEvents(new EventHandler(), $plugin);
		self::$plugin = $plugin;
		return true;
	}

	/**
	 * @return Plugin
	 */
	public static function getPlugin() : Plugin{
		return self::$plugin;
	}

}