<?php if (! defined ("BASEPATH")) exit ('No direct script access allowed');

class Permission {

	public static function validate($params) {
		$config = array(
				"lockname" => "default",
				"u_id" => 0
			);
		// merges user default and the user given parameters
		$config = array_merge($config, $params);

		// user permission overrides the group permission
		$userPerms = new userPerms();
		$groupPerms = new groupPerms();

		// if no user permission associated then, passes the task to GroupPermission
		$userPerms->nextChain($groupPerms);
		$perms = $userPerms->validate($config);

		return $perms;
	}
}