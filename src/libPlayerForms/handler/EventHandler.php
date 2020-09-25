<?php
declare(strict_types=1);
namespace libPlayerForms\handler;

use libPlayerForms\form\element\Button;
use libPlayerForms\form\element\ButtonImage;
use libPlayerForms\form\SimpleForm;
use libPlayerForms\libPlayerForms;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\NetworkStackLatencyPacket;
use pocketmine\network\mcpe\protocol\ServerSettingsRequestPacket;
use pocketmine\network\mcpe\protocol\ServerSettingsResponsePacket;
use pocketmine\Player;
use function is_null;
use function json_encode;

final class EventHandler implements Listener{

	/**
	 * @param PlayerQuitEvent $event
	 * @priority MONITOR
	 * @ignoreCancelled true
	 */
	public function onPlayerQuit(PlayerQuitEvent $event) : void{
		ImageHandler::removeAllCallbacks($event->getPlayer());
	}

	/**
	 * @param DataPacketSendEvent $event
	 * @priority MONITOR
	 * @ignoreCancelled false
	 */
	public function onDataPacketSend(DataPacketSendEvent $event) : void{
		$packet = $event->getPacket();
		$player = $event->getPlayer();

		switch($packet->pid()){
			case ModalFormRequestPacket::NETWORK_ID:
				if(!$player->isOnline())
					return;
				ImageHandler::registerCallback($player, function() use($player) : void{
					if(!$player->isOnline())
						return;
					ImageHandler::silentUpdate($player);
				});
				break;
		}
	}

	/**
	 * @param DataPacketReceiveEvent $event
	 * @priority MONITOR
	 * @ignoreCancelled false
	 * @throws \ReflectionException
	 */
	public function onDataPacketReceive(DataPacketReceiveEvent $event) : void{
		$packet = $event->getPacket();
		$player = $event->getPlayer();

		switch($packet->pid()){
			case ServerSettingsRequestPacket::NETWORK_ID:
				if(is_null(libPlayerForms::getServerSettingsForm()))
					break;
				$settingsForm = libPlayerForms::getServerSettingsForm();

				$counter = (new \ReflectionClass(Player::class))->getProperty("formIdCounter");
				$counter->setAccessible(true);
				$formId = $counter->getValue($player);
				$counter->setValue($player, $formId + 1);

				$forms = (new \ReflectionClass(Player::class))->getProperty("forms");
				$forms->setAccessible(true);

				$pk = new ServerSettingsResponsePacket();
				$pk->formId = $formId;
				$pk->formData = json_encode($settingsForm);
				if($player->dataPacket($pk) !== false){
					$forms->setValue($player, $forms->getValue($player) + [$formId => $settingsForm]);
				}
				unset($count, $forms);
				$event->setCancelled(true);
				break;
			case NetworkStackLatencyPacket::NETWORK_ID:
				ImageHandler::executeCallback($player, $packet->timestamp);
				break;
		}
	}

}