<?php

class GarageCart implements Icart {

// private:
	private $CI;
	private $state;
	private $session;

	// array's index
	private $root_index = 'cart';
	private $sub_index = 'garage';

	// fields
	private $titles = array();
	private $items = array();
	private $sale_dates = array();
	private $address = array();
	private $accnt_id = 0;
	private $images = array();
	private $payment = "";

// public methods:
	public function __construct() {
		$this->CI = &get_instance();
		$this->read_session();

		// call_debug( $this->session );
		if( $this->is_garage_index_exists()) {
			$this->state = true;
			return ;
		}

		$this->state = false;
	}

	public function add($params = array()) {
		$default = array(
							'key' => '',
							'value' => '',
							'is_array' => true
						);
		$params = array_merge($default, $params);

		if( $params[ 'is_array' ] ) { // new item is array
			// array_push( $this->$params[ 'key' ], (array)$params[ 'value' ]);
			$this->$params[ 'key' ] = (array)$params[ 'value' ];
		} else { // new item is not an array
			$this->$params[ 'key' ] = $params[ 'value' ];
		}

	}

	public function remove($params = array()) {
		echo "Removing through Garage Cart<br />";

	}	

	public function start() {

		if ( $this->state ) {
			$this->titles = $this->retrive_titles();
			$this->items = $this->retrieve_items();
			$this->sale_dates = $this->retrieve_sale_dates();
			$this->address = $this->retrieve_address();
			$this->images = $this->retrieve_images();
			$this->accnt_id = $this->retrieve_accnt_id();
			$this->payment = $this->retrieve_payment();
		} else { // create the whole session
			$this->state = true;
			$this->force_create_save_session();
		}

	}

	public function end() {
		if ( $this->state ) {
			// session_setter($data);
			$this->force_create_save_session();
		} else {
			Throw new GarageCartHandler("Session data integrity failed.");
			
		}

	}

// private methods:
	private function force_create_save_session() {
		$arr[ $this->sub_index ][ 'titles' ] =  $this->titles;
		$arr[ $this->sub_index ][ 'items' ] =  $this->items;
		$arr[ $this->sub_index ][ 'sale_dates' ] =  $this->sale_dates;
		$arr[ $this->sub_index ][ 'address' ] =  $this->address;
		$arr[ $this->sub_index ][ 'images' ] =  $this->images;
		$arr[ $this->sub_index ][ 'accnt_id' ] =  $this->accnt_id;
		$arr[ $this->sub_index ][ 'payment' ] =  $this->payment;
		$data = array( $this->root_index => json_encode($arr) );
		session_setter($data);

	}

	private function retrive_titles() {
		$arr = ( array_key_exists('titles', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->titles : array();
		return (array)$arr;

	}

	private function retrieve_items() {
		$arr = ( array_key_exists('items', $this->session[ $this->root_index ][ $this->sub_index ]) ) ? $this->session[ $this->root_index ][ $this->sub_index ]->items : array();
		return (array)$arr;

	}

	private function retrieve_sale_dates() {
		$arr = ( array_key_exists('sale_dates', $this->session[ $this->root_index ][ $this->sub_index ]) ) ? $this->session[ $this->root_index ][ $this->sub_index ]->sale_dates : array();
		return (array)$arr;

	}

	private function retrieve_address() {
		$arr = ( array_key_exists('address', $this->session[ $this->root_index ][ $this->sub_index ]) ) ? $this->session[ $this->root_index ][ $this->sub_index ]->address : array();
		return (array)$arr;

	}

	private function retrieve_images() {
		$arr = ( array_key_exists('images', $this->session[ $this->root_index ][ $this->sub_index ]) ) ? $this->session[ $this->root_index ][ $this->sub_index ]->images : array();
		return (array)$arr;

	}

	private function retrieve_accnt_id() {
		$arr = ( array_key_exists('accnt_id', $this->session[ $this->root_index ][ $this->sub_index ]) ) ? $this->session[ $this->root_index ][ $this->sub_index ]->accnt_id : 0;
		return $arr;

	}

	private function retrieve_payment() {
		$arr = ( array_key_exists('payment', $this->session[ $this->root_index ][ $this->sub_index ]) ) ? $this->session[ $this->root_index ][ $this->sub_index ]->payment : "";
		return $arr;

	}

	private function read_session() {
		$params = array( $this->root_index );
		$this->CI->sessionbrowser->getInfo($params);
		$arr = $this->CI->sessionbrowser->mData;
		
		foreach ($arr as $key => $value) {
			$arr = array($key => (array)json_decode($value));
		}
		$this->session = $arr;

	}

	private function is_garage_index_exists() {
		if( array_key_exists( $this->sub_index, $this->session[ $this->root_index ]) )
			return true;
		return false;

	}

}

class GarageCartHandler extends Exception {

	public function error() {
		$error = "You have an error on line " . $this->getLine() . "<br />" . $this->getMessage();
	}
}