<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use function gettype;
use function is_null;

final class Label extends CustomFormElement{

	/**
	 * Label constructor.
	 * @param string $text
	 */
	public function __construct(string $text){
		parent::__construct($text, self::TYPE_LABEL);
	}

	/**
	 * @internal this is for validate the returned value
	 * @param mixed $value
	 * @throws CustomFormElementValidationException
	 */
	public function validate($value) : void{
		if(!is_null($value))
			throw new CustomFormElementValidationException("Expected null, got " . gettype($value));
	}

}