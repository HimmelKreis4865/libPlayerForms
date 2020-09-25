<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use function gettype;

final class Toggle extends CustomFormElement{

	/**
	 * Toggle constructor.
	 * @param string $text
	 * @param bool $default
	 */
	public function __construct(string $text, bool $default = true){
		parent::__construct($text, self::TYPE_TOGGLE);
		$this->data["default"] = $default;
	}

	/**
	 * @internal this is for validate the returned value
	 * @param mixed $value
	 * @throws CustomFormElementValidationException
	 */
	public function validate($value) : void{
		if(!is_bool($value))
			throw new CustomFormElementValidationException("Expected bool, got " . gettype($value));
	}

}