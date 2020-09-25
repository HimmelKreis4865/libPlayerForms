<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use function gettype;
use function is_int;

final class Dropdown extends CustomFormElement{

	/**
	 * Dropdown constructor.
	 * @param string $text
	 * @param array $options
	 * @param int $default
	 */
	public function __construct(string $text, array $options, int $default = 0){
		parent::__construct($text, self::TYPE_DROPDOWN);
		if(!isset($options[$default]))
			throw new \InvalidArgumentException("Dropdown default should be set in options");
		$this->data["options"] = $options;
		$this->data["default"] = $default;
	}

	/**
	 * @internal this is for validate the returned value
	 * @param mixed $value
	 * @throws CustomFormElementValidationException
	 */
	public function validate($value) : void{
		if(!is_int($value))
			throw new CustomFormElementValidationException("Expected int, got " . gettype($value));
	}

}