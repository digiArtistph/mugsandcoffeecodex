<?php
namespace alamid\classes;

use alamid\interfaces\INotificationReader;

class NotifReaderGroup implements INotificationReader {

	private $mCI;

	public function __construct() {

		// echo "Initializing NotifReaderUser Class...<br />";
		$this->mCI =& get_instance();	
	}

	public function pull($params = array()) {
		$user_id = $this->getCurrentUser();
		$postCounter = 0;
		$userJoinCommCounter = 0;
		$userInivitedJoinCommCounter = 0;
		$strQry =  sprintf("SELECT r.request, rt.type, r.options, sl.occured AS `timestamp` FROM requests r LEFT JOIN request_types rt ON r.request=rt.rt_id LEFT JOIN sys_log sl ON r.hash=sl.hash WHERE (status = 0) ORDER BY occured DESC", $user_id);
		$arrSummary = array();

		$result = $this->mCI->db->query($strQry)->result();
			// call_debug( $result );

		// summarizes
		foreach ($result as $req) {
			// post approval requeset
			if($req->request == 3) {
				$postCounter ++;
			}

			// communitiy owner invites user to join the community
			if($req->request == 2) {
				$userInivitedJoinCommCounter++;
			}

			// user joins the community
			if($req->request == 1) {
				$userJoinCommCounter++;
			}
		}

		array_push($arrSummary, array("post" => $postCounter) );
		array_push($arrSummary, array("userjoincomm" => $userJoinCommCounter) );
		array_push($arrSummary, array("userinvitedjoincomm" => $userInivitedJoinCommCounter) );
		// call_debug( $arrSummary, false );
		// echo count($arrSummary) . " Notifications<br />";
		return json_encode($arrSummary);
	}

	private function getCurrentUser() {

		return session_get_user_id();
	}
}