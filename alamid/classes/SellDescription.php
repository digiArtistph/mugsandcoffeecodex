<?php

class SellDescription  implements IDescription {

	private $mConfig;

	public function __construct($params) {
		// echo "Initializing SellDescription class.<br />";
		$config = array(
				"title" => "Some Title",
				"description" => "Some description",
				"street" => "",
				"price" => 0
			);

		$this->mConfig = array_merge($config, $params);
	}

	public function getDescription() {

		$output = "";
		$output .= "<div class='post-description'>";	
		$output .= "<div class='title'>" . $this->mConfig['title'] . "</div>";
		$output .= "<div class='price'>" . getCurrency(). 	$this->mConfig['price'] . " -- " . (($this->mConfig['street'] != "") ? $this->mConfig['street'] . ", " : "") . $this->mConfig['city'] .  "</div>";
		$output .= "<div class='description'>" . $this->mConfig['description'] . "</div>";
		$output .= "</div>";
		return $output;
	}
}