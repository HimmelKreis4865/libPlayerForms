<?php
declare(strict_types=1);
namespace libPlayerForms\form\element\custom;

use libPlayerForms\form\element\Element;

abstract class CustomFormElement extends Element implements CustomFormElementIds{

	/** @var string */
	protected $text;

	/** @var string */
	protected $type;

	/** @var array */
	protected $data = [];

	/**
	 * CustomFormElement constructor.
	 * @param string $text
	 * @param string $type
	 */
	public function __construct(string $text, string $type){
		$this->text = $text;
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getType() : string{
		return $this->type;
	}

	/**
	 * @return array
	 */
	public function getData() : array{
		return $this->data;
	}

	/**
	 * @return array
	 */
	public function asArray() : array{
		return [
				"type" => $this->type,
				"text" => $this->text
		] + $this->data;
	}

	/**
	 * @internal this is for validate the returned value
	 * @param mixed $value
	 * @throws CustomFormElementValidationException
	 */
	abstract public function validate($value) : void;

}