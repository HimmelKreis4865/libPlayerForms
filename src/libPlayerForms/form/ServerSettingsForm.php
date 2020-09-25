<?php
declare(strict_types=1);
namespace libPlayerForms\form;

use libPlayerForms\form\element\serversettings\ServerSettingsIcon;

class ServerSettingsForm extends CustomForm{

	/** @var ServerSettingsIcon|null */
	protected $icon;

	/**
	 * ServerSettingsForm constructor.
	 * @param string $title
	 * @param ServerSettingsIcon|null $icon
	 */
	public function __construct(string $title, ?ServerSettingsIcon $icon = null){
		parent::__construct($title);
		$this->icon = $icon;
	}

	/**
	 * @return ServerSettingsIcon|null
	 */
	public function getIcon() : ?ServerSettingsIcon{
		return $this->icon;
	}

	/**
	 * @param ServerSettingsIcon $icon
	 * @return ServerSettingsForm
	 */
	public function setIcon(ServerSettingsIcon $icon) : ServerSettingsForm{
		$this->icon = $icon;
		return $this;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() : array{
		$ret = parent::jsonSerialize();
		if($this->icon !== null)
			$ret += [
				"icon" => $this->icon->asArray()
			];
		return $ret;
	}

}