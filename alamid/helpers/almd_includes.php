<?php
/**
 * 
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Monday, June 23, 2014
 * @version 1.0
 *
 *
 * Hierarchy of tail_on calls
 * 		[head_section]
 *          css: 0- 9
 *			script link: 10-19
 *    		script embedded; 20
 *
 *		[user_dashboard_sidebar_section]
 *			sidebar: 21 - 40
 *
 */
if(!function_exists('tail_on')) {
	function tail_on($tail, $funcname, $order = 0, $mixed = null) {
		global $almd_activities;
		 $almd_activities;

		$data = array(
				'name' => $funcname,
				'order' => $order
			);

		// if(null != $modules)
		// 	$data = array_merge($data, array($'index' => ));

		$almd_activities[$tail][] = $data;
	}
}