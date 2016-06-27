<?php
/**
 * This helps finding necessary template files and helps building the whole template
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Tuesday, June 17, 2014
 * @version 1.0
 */
if(!function_exists("ald_build_head")) {
	function ald_build_head() {

		global $almd_activities;
		$almd_head = almd_sort_combine_array($almd_activities['head_section']);

		foreach ($almd_head as $key => $func) {
			if(almd_is_valid_function($func)) {
				call_user_func($func);
			}
		}

	}
}

/**
 * Builds the front-end sidebar
 * HOOK: left_sidebar_section
 * example: tail_on( "left_sidebar_section", <user-defined-function>);
 */
if(!function_exists("almd_build_left_sidebar")) {
	function almd_build_left_sidebar() {

		global $almd_activities;
		$almd_head = almd_sort_combine_array($almd_activities['left_sidebar_section']);

		foreach ($almd_head as $key => $func) {
			if(almd_is_valid_function($func)) {
				call_user_func($func);
			}
		}

	}
}

/**
 * Builds the dashboar-profile sidebar
 * HOOK: user_dashboard_sidebar_section
 * example: tail_on( "user_dashboard_sidebar_section", <user-defined-function>);
 */
if(!function_exists("almd_build_user_dashboard_sidebar")) {
	function almd_build_user_dashboard_sidebar() {
		
		global $almd_activities;
		$almd_head = almd_sort_combine_array($almd_activities['user_dashboard_sidebar_section']);
			// call_debug( $almd_head );
		foreach ($almd_head as $key => $func) {
			if(almd_is_valid_function($func)) {
				call_user_func($func);
			}
		}

	}
}

/**
 * Loops the postroll data
 * HOOK: user_dashboard_sidebar_section
 * example: tail_on( "user_dashboard_sidebar_section", <user-defined-function>);
 */
if(!function_exists("almd_postroll")) {
	function almd_postroll() {
		
		global $almd_activities;
		$almd_head = almd_sort_combine_array($almd_activities['the_postroll']);

		foreach ($almd_head as $key => $func) {
			if(almd_is_valid_function($func)) {
				call_user_func($func);
			}
		}

	}
}

if( ! function_exists("almd_build_admin_dashboard_sidebar")) {
	function almd_build_admin_dashboard_sidebar() {
		global $almd_activities;
		$almd_head = almd_sort_combine_array($almd_activities['admin_dashboard_sidebar_section']);

		foreach ($almd_head as $key => $func) {
			if(almd_is_valid_function($func)) {
				call_user_func($func);
			}
		}
	}
}


/**
 * Checks if the named function is really a function
 * @param string name of the function
 * @return boolean true/false
 * @since Tuesday, June 17, 2014
 * @version 1.0.0
 */
if(!function_exists('almd_is_valid_function')) {
	function almd_is_valid_function($funcname) {

		return (!is_callable($funcname)) ? false : true;
	}
}

/**
 * Sorts a multi-dimensional array and sorts it
 * @param multi-array Array
 * @return new-array Sorted array
 * @since Tuesday, June 17, 2014
 * @version 1.0.2
 */
if(!function_exists('almd_sort_combine_array')) {
	function almd_sort_combine_array($multiArray) {
		$firstArray = array();
		$secondArray = array();
		$newArray = array();

		// print_r($multiArray); die();
		foreach ($multiArray as $value) {
			$firstArray[] = $value['order'];
			$secondArray[] = $value['name'];
		}

		// sorts the array
		array_multisort($firstArray, SORT_ASC, SORT_NUMERIC, $secondArray);

		// combines arrays
		$newArray = array_combine($firstArray, $secondArray);
		//
		return $newArray;
	}
}