<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use function gettype;
use function is_int;

final class StepSlider extends CustomFormElement{

	/**
	 * StepSlider constructor.
	 * @param string $text
	 * @param array $steps
	 * @param int|null $default
	 */
	public function __construct(string $text, array $steps, int $default = 0){
		parent::__construct($text, self::TYPE_STEP_SLIDER);
		if(!isset($steps[$default]))
			throw new \InvalidArgumentException("Step slider default should be set in steps");
		$this->data["steps"] = $steps;
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