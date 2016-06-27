<?php

$cron = new Cron();
$result = $cron->execute();
// $result = $cron->readTable();
// // echo "<pre />";
// // print_r($results);
// // die();
// while($rec = $result->fetch_object()) {
// 	$output = sprintf("%d -- %d -- %s <br />", $rec->u_id, $rec->online, $rec->stamp);
// 	echo $output;
// }

class Cron {
	private $db;
	private $table;

	public function __construct () {
		echo "Initializing Cron Class...<br />";
		$params = array(
						"host" => "localhost",
						"user" => "root",
						"password" => "",
						"db" => "wimtownnew"
					);
		// $params = array(
		// 				"host" => "localhost",
		// 				"user" => "cd607cbabc83",
		// 				"password" => "1fb3c07e21a8971d",
		// 				"db" => "wimtown"
		// 			);

		$this->table = "online_users";
		$this->db = new Database($params);
		$this->db = $this->db->retrieveDB();
	}

	public function readTable() { // retrieves all online users

		$strQry = "SELECT * FROM {$this->table}";
		return $this->db->query($strQry);
	}

	public function execute() { // runs this object
		$result = $this->getResultSet($this->readTable());

		// callDebug::printArr($result, false);
		// loops through the resultset
		foreach ($result as $rec) {
			// checks online status
				// updates user's online status
				
			$output = sprintf("%d -- %d -- %s <br />", $rec->u_id, $rec->online, $rec->stamp);

			// use for time stamping
			date_default_timezone_set("Asia/Manila"); // @todo: transfer this into config.php or system settings
			// date_default_timezone_set("America/Los_Angeles"); // @todo: transfer this into config.php or system settings
			$now = date('Y-m-d H:i:s');

			if ((onlineChecker::getStatus(array("timestamp" => $rec->stamp)) == false) && ($rec->online == 1) ) {
				$output = "Online " . $output;
				$this->updateTable($rec->u_id, 0);
			}

			// echo $output;
		}

	}

	private function getResultSet($db) {
		$result;

		while($obj = $db->fetch_object()) {
			$result[] = $obj;
		}

		return $result;
	}

	private function updateTable($user_id, $online_status) { // updates all online users
		$strQry = sprintf("INSERT INTO online_users (u_id, online) VALUES(%d, %d) ON DUPLICATE KEY UPDATE online = %d",
					$user_id, $online_status, $online_status);

		return $this->db->query($strQry);
	}



}

class Database {
	private $db;
	private $host;
	private $user;
	private $password;
	private $mysqli = null;

	public function __construct($params) {
		// echo "<pre/>";
		// print_r($params); die();
		// echo "Initializing Database Class....<br />";
		$this->db = $params['db'];
		$this->host = $params['host'];
		$this->user = $params['user'];
		$this->password = $params['password'];

		// opens connection
		$this->connectDb();
	}

	public function retrieveDB() {

		return $this->mysqli;
	}

	private function connectDb() {

		// passes user's credentials to the database in order to establish connection
		$this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
	}

}

class onlineChecker {

	private static $gracePeriod = 60;

	public static function getStatus($params) {
		$config = array(
						"status" => "0",
						"timestamp" => date("Y-m-d H:i:s")
					);
		$config = array_merge($config, $params);
		
		// params: initial status and timestamp
		// compare stamp and current datetime
		$online_spanned = online_status_span($config['timestamp']);

		if($online_spanned < self::$gracePeriod)
			return true;
		else
			return false;
	}

	private static function getCurrentDateTime() {
		// returns unix time

		return 0;
	}

	
}

class callDebug {

	public function __construct() {

		echo "Initializing callDebug Class...<br />";
	}

	public static function printArr($params, $halt = true) {
		echo "<pre />";
		print_r($params);

		if ($halt)
			die();
	}
}


function online_status_span($time) {

	date_default_timezone_set("Asia/Manila"); // @todo: transfer this into config.php or system settings
	// date_default_timezone_set("America/Los_Angeles"); // @todo: transfer this into config.php or system settings

	$now = date('Y-m-d H:i:s');
	$result = dateDiff($time, $now, 6, true);

	if ($result['day'] > 0)
		return 86400;

	//Show comment 1 hour ago and so on... MLES 04/12/2015 Phil Time
	if ($result['day'] < 1 && $result['hour'] >  0 )
		return ($result['hour'] * 3600);

	if ($result['day'] < 1 && $result['minute'] > 0 ) 
		return (($result['minute'] * 60) + $result['second']);

	return $result['second'];

}

// Time format is UNIX timestamp or
// PHP strtotime co mpatible strings
/**
 * PHP: Calculate Real Differences Between Two Dates or Timestamps
 * @author http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
 * @since Monday, December 01, 2014
 *
 */
function dateDiff ($time1, $time2, $precision = 6, $raw = false ) {
// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}

// If time1 is bigger than time2
// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}

// Set up intervals and diffs arrays
	$intervals = array('year','month','day','hour','minute','second');
	$diffs = array();

	// Loop thru all intervals
	foreach ($intervals as $interval) {
		// Create temp time from time1 and interval
		$ttime = strtotime('+1 ' . $interval, $time1);
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime("+" . $add . " " . $interval, $time1);
			$looped++;
		}

		$time1 = strtotime("+" . $looped . " " . $interval, $time1);
		$diffs[$interval] = $looped;
	}

	$count = 0;
	$times = array();

	if ( $raw )
		return $diffs;

	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
	// Break if we have needed precission
		if ($count >= $precision) {
			break;
		}
		// Add value and interval 
		// if value is bigger than 0
		if ($value > 0) {
			// Add s if value is not 1
			if ($value != 1) {
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
	// call_debug( $times );
	// Return string with times
	return implode(", ", $times);
}

// crontab script
// chmod +x path/cron.php
// * * * * * /opt/lampp/bin/php /opt/lampp/htdocs/wimtown/alamid/functions/cron.php
