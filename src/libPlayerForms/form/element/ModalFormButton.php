<?php
declare(strict_types=1);
namespace libPlayerForms\form\element;

final class ModalFormButton extends Element{

	public const TYPE_BUTTON_1 = 1;
	public const TYPE_BUTTON_2 = 2;

	/** @var string */
	private $text;

	/** @var int */
	private $type;

	/**
	 * ModalFormButton constructor.
	 * @param string $text
	 * @param int $type
	 */
	public function __construct(string $text, int $type){
		$this->text = $text;
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getText() : string{
		return $this->text;
	}

	/**
	 * @return int
	 */
	public function getType() : int{
		return $this->type;
	}

	/**
	 * @return array
	 */
	public function asArray() : array{
		return [
			"type" => $this->type,
			"text" => $this->text
		];
	}

}