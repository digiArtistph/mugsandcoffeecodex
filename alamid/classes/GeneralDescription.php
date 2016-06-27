<?php

class GeneralDescription implements IDescription {
	private $mConfig;

	public function __construct($params) {
		$config = array(
			"description" => ""
			);

		$this->mConfig = array_merge($config, $params);
	}

	public function getDescription() {
		$output = "";
		$output .= "<div class='post-description'>";
		$output .= "<div class='description'>" . $this->mConfig['description'] . "</div>";
		$output .= "</div>";

		return $output;
	}
}