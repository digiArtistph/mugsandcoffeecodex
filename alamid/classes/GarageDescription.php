<?php

class GarageDescription implements IDescription {

	private $mConfig;
	private $CI;

	public function __construct($params) {
		$this->CI =& get_instance();
		$config = array(
				"description" => "Garage event",
				"street" => "",
				"dates" => array()
			);

		$this->mConfig = array_merge($config, $params);
	}

	public function getDescription() {
		$output = "";
		$output .= "<div class='post-description'>";
		$output .= "<div class='title'>Garage Sale Event" . " -- @ " . (($this->mConfig['street']) != "" ? $this->mConfig['street'] . ", " : "") . $this->mConfig['city'] . "</div>";
		$output .= "<div class='description'>" . $this->mConfig['description'] . "</div>";
		// $output .= "<div class='dates'>" . implode(",", $this->mConfig['dates'] ). "</div>";
		$output .= "</div>";

		$this->getSaleDates($this->mConfig['p_id']);
		return $output;
	}

	private function getSaleDates($p_id) {
		$strQry = sprintf("SELECT * FROM sale_dates WHERE ctl_id=%d", $p_id);
		$records = $this->CI->db->query($strQry)->result();

		return $records;
	}


}