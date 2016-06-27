<?php

class GroupPerms implements IPermission {

	private $mCI;
	private $mLockName;
	private $mLockNameId;
	private $mU_Id;
	private $mNextChain;
	private $mUserGroup;

	const GUEST = 0x01;
	const FREE = 0x02;
	const PREMIUM = 0x04;
	const PUBLISHER_NEWSLETTER = 0x08;
	const PUBLISHER_CONTENT = 0x10;
	const USER_MANAGER = 0x20;
	const PREMIUM_MANAGER = 0x40;
	const ADMIN = 0x80;
	const SUPER_ADMIN = 0x100;

	public function __construct() {

		$this->mCI = &get_instance();
	}

	public function validate($params = array()) {
		$this->mLockName = $params['lockname'];
		$this->mU_Id = $params['u_id'];
			// call_debug( $params );
		$this->mLockNameId = $this->getLockNameId($this->mLockName, $this->mU_Id);
		$this->mUserGroup = $this->getUserGroup($this->mU_Id);
		$perms = $this->getGroupPermissions($this->mLockNameId);
		// on_watch( "groupperms: " . $perms  );
		if($perms >= 1)
			return 1;

		if($perms == 0)
			return 0;

		return 1; // forces to return true due to nothing has been associated of lockname and user/group
	}

	public function nextChain(IPermission $newChain) {
		
		$this->mNextChain = $newChain;
	}

	private function getGroupHex() {
		switch ($this->mUserGroup) {
			case 0:
			case 1:
				return self::GUEST;
			case 2:
				return self::FREE;
			case 3:
				return self::PREMIUM;
			case 4:
				return self::PUBLISHER_NEWSLETTER;
			case 5:
				return self::PUBLISHER_CONTENT;
			case 6:
				return self::USER_MANAGER;
			case 7:
				return self::PREMIUM_MANAGER;
			case 8:
				return self::ADMIN;
			case 9:
				return self::SUPER_ADMIN;
			default:
				return self::GUEST;
		}

	}

	private function getGroupPermissions($locknameId) {
		$strQry = sprintf("SELECT perms FROM permissions WHERE u_id = 0 AND lockname=%d LIMIT 1", $locknameId);
		$records = $this->mCI->db->query($strQry)->result();
			// call_debug( $records, false );
		// on_watch( $strQry, false );
		foreach ($records as $rec) {
			// get the perm - bits
			$group = $this->getGroupHex();
			// on_watch( $group . "<---" );
			$perms = $rec->perms;

			if(($perms & $group) == $group)
				return 1;
			else
				return 0;

		}

		return -1;
	}

	private function getUserGroup($u_id) {
		$strQry = sprintf("SELECT utp_id FROM users WHERE u_id=%d", $u_id);
		$records = $this->mCI->db->query($strQry)->result();

		foreach ($records as $rec) {
			return $rec->utp_id;
		}

		return 0;
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