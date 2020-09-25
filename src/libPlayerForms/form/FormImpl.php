<?php
declare(strict_types=1);
namespace libPlayerForms\form;

use libPlayerForms\form\element\Element;
use libPlayerForms\form\response\FormResponse;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\Utils;

abstract class FormImpl implements Form, FormIds{

	/** @var string */
	protected $title;

	/** @var string */
	protected $type;

	/** @var array */
	protected $data;

	/** @var Element[] */
	protected $elementMap = [];

	/** @var \Closure */
	protected $onSubmit;

	/** @var \Closure */
	protected $onClose;

	/**
	 * FormImpl constructor.
	 * @param string $title
	 * @param string $type
	 */
	public function __construct(string $title = "", string $type = self::TYPE_SIMPLE){
		$this->title = $title;
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getTitle() : string{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return self
	 */
	public function setTitle(string $title) : self{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType() : string{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return self
	 */
	public function setType(string $type) : self{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData() : array{
		return $this->data;
	}

	/**
	 * @param \Closure $callable
	 * @return self
	 */
	public function setSubmitListener(\Closure $callable) : self{
		Utils::validateCallableSignature(function(Player $player, FormResponse $response) : void{}, $callable);
		$this->onSubmit = $callable;
		return $this;
	}

	/**
	 * @param \Closure $callable
	 * @return self
	 */
	public function setCloseListener(\Closure $callable) : self{
		Utils::validateCallableSignature(function(Player $player) : void{}, $callable);
		$this->onClose = $callable;
		return $this;
	}

	/**
	 * @param Player $player
	 */
	public function send(Player $player) : void{
		$player->sendForm($this);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() : array{
		return [
				"title" => $this->title,
				"type" => $this->type
			] + $this->data;
	}

	/**
	 * @param Element $element
	 * @return self
	 */
	abstract public function addElement(Element $element);

	/**
	 * @param Player $player
	 * @param mixed $data
	 */
	abstract public function handleResponse(Player $player, $data) : void;

}