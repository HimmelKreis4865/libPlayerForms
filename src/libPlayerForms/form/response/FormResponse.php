<?php
declare(strict_types=1);
namespace libPlayerForms\form\response;

use libPlayerForms\form\element\Element;

final class FormResponse{

	/** @var Element[] */
	private $elementMap = [];

	/** @var mixed */
	private $actual;

	/**
	 * FormResponse constructor.
	 * @param Element[] $elements
	 * @param mixed $actual
	 */
	public function __construct(array $elements, $actual){
		$this->elementMap = $elements;
		$this->actual = $actual;
	}

	/**
	 * @return Element[]
	 */
	public function getElements() : array{
		return $this->elementMap;
	}

	/**
	 * @param int $id
	 * @return Element|null
	 */
	public function getElementById(int $id) : ?Element{
		return $this->getElements()[$id] ?? null;
	}

	/**
	 * @return mixed
	 */
	public function getActualResponse(){
		return $this->actual;
	}

}