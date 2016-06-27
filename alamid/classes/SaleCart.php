<?php

class SaleCart implements Icart {

	// private:
	private $CI;
	private $state;
	private $session;

	// array's index
	private $root_index = 'cart';
	private $sub_index = 'sale';

	// fields
	private $item_name = "";
	private $address = array();
	private $categories = array();
	private $images = array();
	private $payment = "";
	private $details = "";
	private $accnt_id = 0;
	private $price = 0;
	private $featured = "";

// public methods:
	public function __construct() {
		$this->CI = &get_instance();
		$this->read_session();

		// call_debug( $this->session );
		if( $this->is_sale_index_exists()) {
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
		echo "Removing through Sale Cart<br />";

	}	

	public function start() {

		if ( $this->state ) {
			$this->item_name = $this->retrieve_items();
			$this->categories = $this->retrieve_categories();
			$this->images = $this->retrieve_images();
			$this->details = $this->retrieve_details();
			$this->price = $this->retrieve_price();
			$this->featured = $this->retrieve_featured();

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
			Throw new SaleCartHandler("Session data integrity failed.");
			
		}

	}

// private methods:
	private function force_create_save_session() {
		$arr[ $this->sub_index ][ 'item_name' ] =  $this->item_name;
		$arr[ $this->sub_index ][ 'address' ] =  $this->address;
		$arr[ $this->sub_index ][ 'categories' ] = $this->categories;
		$arr[ $this->sub_index ][ 'images' ] =  $this->images;
		$arr[ $this->sub_index ][ 'details' ] =  $this->details;
		$arr[ $this->sub_index ][ 'accnt_id' ] =  $this->accnt_id;
		$arr[ $this->sub_index ][ 'price' ] =  $this->price;
		$arr[ $this->sub_index ][ 'payment' ] =  $this->payment;
		$arr[ $this->sub_index ][ 'featured' ] =  $this->featured;
		$data = array( $this->root_index => json_encode($arr) );
		session_setter($data);

	}

	private function retrieve_items () {
		$arr = ( array_key_exists('item_name', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->item_name : "";
		return $arr;

	}

	private function retrieve_address () {
		$arr = ( array_key_exists('address', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->address : array();
		return (array)$arr;

	}

	private function retrieve_categories () {
		$arr = ( array_key_exists('categories', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->categories : array();
		return (array)$arr;

	}

	private function retrieve_images () {
		$arr = ( array_key_exists('images', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->images : array();
		return (array)$arr;

	}

	private function retrieve_details () {
		$arr = ( array_key_exists('details', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->details : "";
		return $arr;

	}

	private function retrieve_price () {
		$arr = ( array_key_exists('price', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->price : 0;
		return $arr;

	}

	private function retrieve_payment () {
		$arr = ( array_key_exists('payment', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->payment : "";
		return $arr;

	}

	private function retrieve_featured () {
		$arr = ( array_key_exists('featured', $this->session[ $this->root_index ][ $this->sub_index ])) ? $this->session[ $this->root_index ][ $this->sub_index ]->featured : "";
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

	private function is_sale_index_exists() {
		if( array_key_exists( $this->sub_index, $this->session[ $this->root_index ]) )
			return true;
		return false;

	}

}

class SaleCartHandler extends Exception {

	public function error() {
		$error = "You have an error on line " . $this->getLine() . "<br />" . $this->getMessage();
	}
}