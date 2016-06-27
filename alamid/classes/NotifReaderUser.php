<?php
/**
 * Retrieves notifications from requests table filtered by user id
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Friday, July 3, 2015 at 12:00 PM
 * @version 1.0
 */
namespace alamid\classes;

use alamid\interfaces\INotificationReader;

class NotifReaderUser implements INotificationReader {

	private $mCI;

	public function __construct() {

		// echo "Initializing NotifReaderUser Class...<br />";
		$this->mCI =& get_instance();	
	}

	public function pull($params = array()) {
		$user_id = $params['user_id'];
		$strQry =  sprintf("SELECT r.request, rt.type, r.options, sl.occured AS `timestamp` FROM requests r LEFT JOIN request_types rt ON r.request=rt.rt_id LEFT JOIN sys_log sl ON r.hash=sl.hash WHERE  (options REGEXP 's:4:\"user\";i:%d' ) AND (status = 0) ORDER BY occured DESC", $user_id);
		// on_watch( $strQry );
		$result = $this->mCI->db->query($strQry)->result();
			// call_debug( $result );
		return json_encode($result);
	}

	private function getCurrentUser() {

		return session_get_user_id();
	}

}