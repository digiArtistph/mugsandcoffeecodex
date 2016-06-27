<?php

namespace alamid\classes;

class EmailFactory {

	public static function factory($email) {
		
		switch ($email) {
			case 'customEmail':
				return new CustomEmail();
			case 'ciEmail':
				return new CIEmail();
			default:
		}
	}
}