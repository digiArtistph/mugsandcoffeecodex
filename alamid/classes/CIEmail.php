<?php
/**
 * Sends email using Codeigniter email class
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Saturday, July 4, 2015 at 01:14 AM
 * @version 1.0
 */
namespace alamid\classess;

use alamid\interfaces\IEmail;

class CIEmail implements IEmail {

	private $mCI;
	private $mEmail;
	public function __construct() {
		echo 'Inittializing CIEmail class...<br />';
		$this->mCI =& get_instance();
		$this->mEmail = $this->mCI->load->library('emailutil');
	}

	public function send($params) {
		$config = array(
  						'sender' => 'info@wimtown.com',
  						'receiver' => 'kenn_vall@yahoo.com',
  						'from_name' => 'Super Admin', // OPTIONAL
  						'cc' => '', //'supervisor@otherdomainname.com', // OPTIONAL
  						'subject' => 'Email from CIEmail Class', // OPTIONAL
  						'msg' => 'I am sending this email from CIEmail class', // OPTIONAL
  						'email_temp_account' => TRUE, // OPTIONAL. Uses your specified google account only. Please see this method "_tmpEmailAccount" below (line 111).
  						'usersettings' => array( // 'usersettings' is OPTIONAL
  												'protocol' => 'sendmail',  // OPTIONAL
 												'mailpath' => '/usr/sbin/sendmail', // OPTIONAL
 												'charset' => 'iso-8859-1', // OPTIONAL
 												'wordwrap' => TRUE	 // OPTIONAL
  											) 
  					);

		$config = array_merge($config, $params);
		$this->mEmail->initialize($config);
		$this->mEmail->send();
		
	}

}