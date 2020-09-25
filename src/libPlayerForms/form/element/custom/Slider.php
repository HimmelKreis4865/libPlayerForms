<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use function gettype;
use function is_float;

final class Slider extends CustomFormElement{

	/**
	 * Slider constructor.
	 * @param string $text
	 * @param float $minimum
	 * @param float $maximum
	 * @param float $step
	 * @param float|null $default
	 */
	public function __construct(string $text, float $minimum, float $maximum, float $step = 1.0, ?float $default = null){
		parent::__construct($text, self::TYPE_SLIDER);
		if($minimum > $maximum)
			throw new \InvalidArgumentException("Slider minimum value should be greater or equal to maximum");
		if($step < 0)
			throw new \InvalidArgumentException("Slider step must be greater then zero");
		if($default === null){
			$default = $maximum;
		}
		if($default < $minimum || $default > $maximum)
			throw new \InvalidArgumentException("Slider default must be greater then minimum and less then maximum");
		$this->data["min"] = $minimum;
		$this->data["max"] = $maximum;
		$this->data["step"] = $step;
		$this->data["default"] = $default;
	}

	/**
	 * @internal this is for validate the returned value
	 * @param mixed $value
	 * @throws CustomFormElementValidationException
	 */
	public function validate($value) : void{
		if(!is_int($value) && !is_float($value))
			throw new CustomFormElementValidationException("Expected float, got " . gettype($value));
		if($value < $this->data["min"] || $value > $this->data["max"])
			throw new CustomFormElementValidationException("Slider return value must be greater then minimum and less then maximum");
	}

}