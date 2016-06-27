<?php
/**
 * Checks the user's credential and privilege within the system
 * @license GPL
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Wednesday, May 28, 2014
 * @version 1.0.1
 */
class Uac Implements Isentinel {

	private $mCI = null;
	private $mTable = null;
	private $mID = null;
	private $mEmail = null;
	private $mType = null;
	private $mLogged = null;

	public function __construct() {

		$this->mCI =& get_instance();
		$this->mTable = 'perms';
	}

	public function goFlag() {
		// gets user access
		$result = $this->getUserAccess();

		// returns 
		return $result;	
	}

	private function getUserAccess() {

		
		$url = $this->_getRelevantUriString(uri_string());
		$this->getSessionContext();
		// builds query strings
		$strQry = sprintf("SELECT * FROM $this->mTable WHERE usr_id = %d AND url='%s'", $this->mID, $url);
		$record = $this->mCI->db->query($strQry)->result();
		// @todo: should return the user permission value
		if(empty($record))
			return 1; // user has no access. 

		return 0; //  user has access
	}

	/**
	 * Retrieves the first 3 uri segments
	 * @params $uri String
	 * @returns String or null
	 */
	private function _getRelevantUriString($uri) {

		$output = '';
		$segmntOne = $this->mCI->uri->segment(1);
		$segmntTwo = $this->mCI->uri->segment(2);
		$segmntThree = $this->mCI->uri->segment(3);

		$output = sprintf("%s/%s/%s", $segmntOne, $segmntTwo, $segmntThree);
		preg_match('/[\w\/_-]+(?<!\/)/', $output, $matches);

		return (!empty($matches)) ? $matches[0] : null;
	}

	private function getSessionContext () {
		$sess = $this->mCI->sessionbrowser;

		// getInfo();
		$params = array('uname', 'uemail', 'uid', 'utype', 'islog');
		$sess->getInfo($params); // returns TRUE if successful, otherwise FALSE
		
		// DATA:
		$arr = $sess->mData; // returns array
		$this->mID = $arr['uid'];
		$this->mEmail = $arr['uemail'];
		$this->mType = $arr['utype'];
		$this->mLogged = $arr['islog'];
	}
}