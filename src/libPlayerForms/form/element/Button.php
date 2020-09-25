<?php
declare(strict_types=1);
namespace libPlayerForms\form\element;

use function is_null;

final class Button extends Element{

	/** @var string*/
	private $text;

	/** @var ButtonImage */
	private $image;

	/**
	 * Button constructor.
	 * @param string $text
	 * @param ButtonImage|null $image
	 */
	public function __construct(string $text, ?ButtonImage $image = null){
		$this->text = $text;
		if(!is_null($image))
			$this->image = $image;
	}

	/**
	 * @return string
	 */
	public function getText() : string{
		return $this->text;
	}

	/**
	 * @return ButtonImage
	 */
	public function getImage() : ButtonImage{
		return $this->image;
	}

	public function asArray() : array{
		$ret = [
			"text" => $this->text
		];
		if($this->image !== null)
			$ret["image"] = $this->image->asArray();
		return $ret;
	}

}