<?php

class IsoInoDescription implements IDescription {

	private $mConfig;

	public function __construct($params) {
		$config = array(
			"isoino" => "",
			"description" => ""
			);

		$this->mConfig = array_merge($config, $params);
	}

	public function getDescription() {
		$isoino = (strtolower($this->mConfig['isoino']) == "iso") ? "<strong>(ISO)</strong> <em>In search of</em>" : "<strong>(INO) </strong><em>In need of</em>";

		$output = "";
		$output .= "<div class='post-description'>";
		$output .= "<div class='isoino'>$isoino</div>";
		$output .= "<div class='description'>" . $this->mConfig['description'] . "</div>";
		$output .= "</div>";

		return $output;
	}

}