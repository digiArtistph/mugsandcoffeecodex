<?php
/**
 * Sends email using ElasticEmail HTTP API
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Saturday, July 4, 2015 at 01:14 AM
 * @version 1.0
 */

namespace alamid\classes;

use alamid\interfaces\IEmail;

class CustomEmail implements IEmail {

	public function __construct() {
		
		echo "Initializing CustomEmail class <br />";
	}

	public function send($params) {

		$config = array(
						"to" => "kenn_vall@yahoo.com", 
						"subject" => "My Subject: Sending from CustomEmail Class",
						"body_text" => "", // body text shouldn't be used
						"body_html" => "body_html: I'm sending this email from CustomEmail Class",
						"from" => "info@wimtown.com",
						"fromName" => "Super Admin"
					);

		$config = array_merge($config, $params);
		$this->sendElasticEmail($config["to"], $config["subject"], $config["body_text"], $config["body_html"], $config["from"], $config["fromName"]);
	}

	private function sendElasticEmail($to, $subject, $body_text, $body_html, $from, $fromName) {
	    $res = "";

	    $data = "username=".urlencode("sender@wimtown.com");
	    $data .= "&api_key=".urlencode("42693fc0-d930-4924-b7ef-1feae9b5a795");
	    $data .= "&from=".urlencode($from);
	    $data .= "&from_name=".urlencode($fromName);
	    $data .= "&to=".urlencode($to);
	    $data .= "&subject=".urlencode($subject);

	    if($body_html)
	      $data .= "&body_html=".urlencode($body_html);
	    if($body_text)
	      $data .= "&body_text=".urlencode($body_text);

	    $header = "POST /mailer/send HTTP/1.0\r\n";
	    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
	    $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

	    if(!$fp)
	      return "ERROR. Could not open connection";
	    else {
	      fputs ($fp, $header.$data);
	      while (!feof($fp)) {
	        $res .= fread ($fp, 1024);
	      }
	      fclose($fp);
	    }
	    return $res;                  
	}
	
}