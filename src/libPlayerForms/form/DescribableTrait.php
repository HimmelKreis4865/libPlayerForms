<?php
declare(strict_types=1);
namespace libPlayerForms\form;

trait DescribableTrait{

	/** @var string */
	protected $description;

	/**
	 * @return string
	 */
	public function getDescription() : string{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return self
	 */
	public function setDescription(string $description) : self{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() : array{
		$ret = parent::jsonSerialize();
		$ret["content"] = $this->description;
		return $ret;
	}

}