<?php
declare(strict_types=1);
namespace libPlayerForms\form;

use libPlayerForms\form\element\Button;
use libPlayerForms\form\element\Element;
use libPlayerForms\form\response\FormResponse;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use function gettype;
use function is_int;
use function is_null;

class SimpleForm extends FormImpl{

	use DescribableTrait;

	/**
	 * SimpleForm constructor.
	 * @param string $title
	 * @param string $content
	 */
	public function __construct(string $title, string $content = ""){
		parent::__construct($title, self::TYPE_SIMPLE);
		$this->description = $content;
		$this->data["buttons"] = []; // if the user wants an empty form
	}

	/**
	 * @param Element $element
	 * @return SimpleForm
	 *
	 */
	public function addElement(Element $element){
		if(!$element instanceof Button)
			throw new \InvalidArgumentException("Expected Button, got " . gettype($element));
		$this->data["buttons"][] = $element->asArray();
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
		if(is_int($data)){
			if(!isset($this->elementMap[$offset = $data]))
				throw new FormValidationException("Offset $offset does not exist");
			if(is_null($this->onSubmit))
				return;
			($this->onSubmit)($player, new FormResponse($this->elementMap, $data));
			return;
		}
		throw new FormValidationException("Expected int or null, got " . gettype($data));
	}

}