<?php
declare(strict_types=1);
namespace libPlayerForms\form\element;

class ButtonImage extends Element{

	public const TYPE_PATH = "path";
	public const TYPE_URL = "url";

	/** @var string */
	private $url;

	/** @var string */
	private $type;

	/**
	 * ButtonImage constructor.
	 * @param string $url
	 * @param string $type
	 */
	public function __construct(string $url, string $type = self::TYPE_PATH){
		$this->url = $url;
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getUrl() : string{
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function getType() : string{
		return $this->type;
	}

	public function asArray() : array{
		return [
			"type" => $this->type,
			"data" => $this->url
		];
	}

}