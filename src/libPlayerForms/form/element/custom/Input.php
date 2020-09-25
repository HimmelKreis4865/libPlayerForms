<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use function gettype;
use function is_string;

final class Input extends CustomFormElement{

	/**
	 * Input constructor.
	 * @param string $text
	 * @param string $placeholder
	 * @param string $default
	 */
	public function __construct(string $text, string $placeholder = "", string $default = ""){
		parent::__construct($text, self::TYPE_INPUT);
		$this->data["placeholder"] = $placeholder;
		$this->data["default"] = $default;
	}

	/**
	 * @internal this is for validate the returned value
	 * @param mixed $value
	 * @throws CustomFormElementValidationException
	 */
	public function validate($value) : void{
		if(!is_string($value))
			throw new CustomFormElementValidationException("Expected string, got " . gettype($value));
	}

}