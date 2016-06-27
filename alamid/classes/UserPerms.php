<?php

class UserPerms implements IPermission {

	private $mCI;
	private $mLockName;
	private $mLockNameId;
	private $mU_Id;
	private $mNextChain;

	public function __construct() {

		$this->mCI = &get_instance();
	}

	public function validate($params = array()) {
		$this->mLockName = $params['lockname'];
		$this->mU_Id = $params['u_id'];

		$this->mLockNameId = $this->getLockNameId($this->mLockName, $this->mU_Id);
		$perms = $this->getUserPermissions($this->mLockNameId, $this->mU_Id);
		// on_watch( "userperm: " . $perms );
		if($perms >= 1)
			return 1;

		if($perms == 0)
			return 0;

		return $this->mNextChain->validate($params);
	}

	public function nextChain(IPermission $newChain) {
		$this->mNextChain = $newChain;
	}

	private function getUserPermissions($locknameId, $u_id) {
		if($u_id == 0)
			return -1;
		
		$strQry = sprintf("SELECT perms FROM permissions WHERE lockname = %d AND u_id = %d LIMIT 1", $locknameId, $u_id);
		// on_watch( $strQry,false );
		$records = $this->mCI->db->query($strQry)->result();
			// call_debug( $records );
		foreach ($records as $rec) {
			return $rec->perms;
		}

		return -1; // no lockname has been assigned to this user
	}

	private function getLockNameId($name, $u_id) {
		$strQry = sprintf("SELECT lc_id FROM locks WHERE lockname='%s' LIMIT 1", $name);
		$records = $this->mCI->db->query($strQry)->result();

		foreach ($records as $rec) {
			return $rec->lc_id;
		}

		return 0;
	}
}