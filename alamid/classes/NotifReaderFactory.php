<?php
/**
 * Retrieves allnotifications from requests table
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Friday, July 3, 2015 at 12:00 PM
 * @version 1.0
 */
namespace alamid\classes;

class NotifReaderFactory {

	public static function factory($notifaction) {
		switch ($notifaction) {
			case 'group':
				return new NotifReaderGroup();
			case 'user':
			default:
				return new NotifReaderUser();
		}
	}

}