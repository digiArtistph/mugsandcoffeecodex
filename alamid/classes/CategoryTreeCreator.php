<?php
/**
 * This will make a simple breadcrumbs from the category table
 * @author Kenneth P. Vallejos
 * @since Friday, July 18, 2014
 * @param array an an associative array which have the following indices: cat_id, name & parent
 * @version 1.1.0
 */
class CategoryTreeCreator {

// private:
	// create an iterator
	private $iterator;	
	// create a multi-dimensional array
	private $multi_array_categories;
	// create a private member variable that holds the tree of categories
	private $single_tree_category;
	// string array that keeps the tree of categories
	private $string_array_categories;
	// holds the current tree of categories while in the recursive mode
	private $recursive_tree_categories;
	// create a method the builds the entire hierarchy of categories -- string
	private $forest_category;


// public methods:
	public function __construct( $obj = array() ) {
		// casts into array
		if(!is_array( $obj ))
			$obj = (array) $obj;

		// call_debug($obj);

		// initializes some member variables
		$this->multi_array_categories = array();
		$this->single_tree_category = "";
		$this->forest_category = "";
		$this->recursive_tree_categories = "";
		$this->string_array_categories = array();

		// creates an iterator
		$this->iterator = $this->create_iterator( $obj );
		
		// fills the $multi_array_categories array
		$this->create_multi_array_categories();

		$this->build_tree_category();

		// cleans the string_array_categories array
		$this->trim_string_categories();

	}

	public function get_multi_tree () {
		return $this->multi_array_categories;

	}

	public function get_string_array_categories () {
		return $this->string_array_categories;

	}

// private methods:
	private function create_iterator ( $arrObj ) {
		$arr_obj = new ArrayObject( $arrObj );
		return $arr_obj->getIterator();

	}

	private function create_multi_array_categories () {
		// fills the $multi_array_categories array
		while ($this->iterator->valid()) {
			$this->multi_array_categories[ $this->iterator->current()->cat_id ] = array(
														'cat_id' => $this->iterator->current()->cat_id,
														'name' => $this->iterator->current()->name,
														'parent' => $this->iterator->current()->parent
													);			
			$this->iterator->next();
		}

	}

	private function build_tree_category () { 
		foreach($this->multi_array_categories as $key => $val) {
			$this->treeish( $key );
			// $this->string_array_categories = $this->recursive_tree_categories;
			array_push($this->string_array_categories, $this->recursive_tree_categories);
			$this->recursive_tree_categories = "";
		}
	}

	private function treeish ( $index ) {

		if( $this->multi_array_categories[ $index ][ 'parent' ] == 0 ) {
			$this->recursive_tree_categories = $this->multi_array_categories[ $index ][ 'name' ] . ">>" . $this->recursive_tree_categories;
		} else {
			$this->recursive_tree_categories = $this->multi_array_categories[ $index ][ 'name' ] . ">>" . $this->recursive_tree_categories;
			$this->treeish( $this->multi_array_categories[ $index ][ 'parent' ] );
		}
	}

	private function trim_string_categories () {
		$obj = new ArrayObject( $this->string_array_categories );
		$iterator = $obj->getIterator();
		$tmp_arr = array();

		while ($iterator->valid()) {
			$tmp_arr[] = $this->trim_end( $iterator->current());
			$iterator->next();
		}

		$this->string_array_categories = array_unique( $tmp_arr, SORT_REGULAR);
	}

	private function trim_end ( $value ) {
		return substr($value, 0, -2);

	}
}

class CategoryTreeCreatorHandler extends Exception {

	public function error() {
		$error = "You have an error on line " . $this->getLine() . "<br />" ;
		return $error;

	}
}
