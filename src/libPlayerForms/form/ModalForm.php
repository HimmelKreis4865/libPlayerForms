<?php
declare(strict_types=1);
namespace libPlayerForms\form;

use libPlayerForms\form\element\Element;
use libPlayerForms\form\element\ModalFormButton;
use libPlayerForms\form\response\FormResponse;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use function count;
use function gettype;
use function is_null;

class ModalForm extends FormImpl{

	use DescribableTrait;

	/**
	 * ModalForm constructor.
	 * @param string $title
	 * @param string $content
	 */
	public function __construct(string $title, string $content = ""){
		parent::__construct($title, self::TYPE_MODAL);
		$this->description = $content;
	}

	/**
	 * @param Element $element
	 * @return self
	 */
	public function addElement(Element $element){
		if(!$element instanceof ModalFormButton)
			throw new \InvalidArgumentException("Expected ModalFormButton, got " . gettype($element));
		if(count($this->elementMap) >= 2)
			throw new \InvalidArgumentException("Tried to register an already registered button");
		$this->data[$element->getType() !== ModalFormButton::TYPE_BUTTON_2 ? "button1" : "button2"] = $element->getText();
		$this->elementMap[] = $element;
		return $this;
	}

	/**
	 * @param Player $player
	 * @param mixed $data
	 */
	public function handleResponse(Player $player, $data) : void{
		if(is_null($data)){
			if(is_null($this->onClose))
				return;
			($this->onClose)($player);
			return;
		}
		if(is_bool($data)){
			if(is_null($this->onSubmit))
				return;
			($this->onSubmit)($player, new FormResponse($this->elementMap, $data));
			return;
		}
		throw new FormValidationException("Expected bool or null, got " . gettype($data));
	}

}