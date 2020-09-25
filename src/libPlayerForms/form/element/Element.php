<?php
declare(strict_types=1);
namespace libPlayerForms\form\element;

abstract class Element{

	/**
	 * @return array
	 */
	abstract public function asArray() : array;

}