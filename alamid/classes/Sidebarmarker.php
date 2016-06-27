<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sidebarmarker {

	private $mContainer = null;
	private $mMenuItems = null;
	private $mController = null;
	private $mMethod = null;
	private $mDefault = false;

	// public function __construct() {
	// 	echo "Sidebarmarker....<br/>";
	// }

	public function initiate($params = array()) {
		// gets the uri segment
		$CI =& get_instance();
		$this->mController = $CI->uri->segment('1');
		// seggregates menu items
		$this->mMethod = $CI->uri->segment('2');

		$this->mContainer = $params['container'];
		$this->mMenuItems = $params['items'];
		$this->mDefault = $params['default'];

	}

	public function getContainerTag($tag) {
		if(($this->mMethod == "" ) && ($this->mDefault == true))
			$this->mMethod = $this->mMenuItems[0];

		if( ($tag == $this->mController) && (in_array($this->mMethod, $this->mMenuItems)) ) {
			return ' in ';
		}

		// exceptions
		if(($this->mController == 'usrpage') && (in_array("my_page", $this->mMenuItems)))
			return 'in';
		
	}

	public function getMenuItemTag($tag) {
		if(($this->mMethod == "" ) && ($this->mDefault == true))
			$this->mMethod = $this->mMenuItems[0];

		if( ($tag == $this->mMethod) && ($this->mController == $this->mContainer) ) {
			return ' class="active" ';
		}

		// exceptions
		if( ($tag == "my_page") && ($this->mController == "usrpage") ) 
			return ' class="active" ';
	}

	
}