<?php
declare(strict_types=1);
namespace libPlayerForms\form;

use libPlayerForms\form\element\custom\CustomFormElement;
use libPlayerForms\form\element\custom\CustomFormElementValidationException;
use libPlayerForms\form\element\Element;
use libPlayerForms\form\response\FormResponse;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use function gettype;
use function is_array;
use function is_null;

class CustomForm extends FormImpl{

	/**
	 * CustomForm constructor.
	 * @param string $title
	 */
	public function __construct(string $title){
		parent::__construct($title, self::TYPE_CUSTOM);
	}

	/**
	 * @param Element $element
	 * @return self
	 */
	public function addElement(Element $element){
		if(!$element instanceof CustomFormElement)
			throw new \InvalidArgumentException("Expected CustomFormElement, got " . gettype($element));
		$this->data["content"][] = $element->asArray();
		$this->elementMap[] = $element;
		return $this;
	}

	/**
	 * @param Player $player
	 * @param mixed $data
	 */
	public function handleResponse(Player $player, $data) : void{
		if(is_null($data)){
			if(!is_null($this->onClose))
				($this->onClose)($player);
			return;
		}
		if(is_array($data)){
			/** @var CustomFormElement[] $map */
			if(($count = count($data)) !== ($expected = count($map = $this->elementMap)))
				throw new FormValidationException("Expected $expected elements, got $count instead");
			foreach($data as $index => $value){
				if(!isset($map[$index]))
					throw new FormValidationException("Offset $index does not exist");
				try{
					$map[$index]->validate($value);
				}catch(CustomFormElementValidationException $e){
					throw new FormValidationException("Element $index: {$e->getMessage()}");
				}
			}
			if(is_null($this->onSubmit))
				return;
			($this->onSubmit)($player, new FormResponse($this->elementMap, $data));
			return;
		}
		throw new FormValidationException("Expected array or null, got " . gettype($data));
	}

}