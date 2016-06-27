<?php
/**
 * Generates html elements
 * @license GPL
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Friday, July 11, 2014
 * @version 1.0.1
 */
class Template implements Itemplate {

	// expects the file format
	private static $m_format;
	
	// file's valid path and file
	private static $m_pathfile;
	
	// default dom to be returned
	private static $m_default_dom = '<div></div>';

	public static function render($params = array()) {
		
		return self::_read_template_content($params);

	}

	private static function _read_template_content($params = array()) {
		
		if(array_key_exists('format', $params))
			self::$m_format = $params['format'];
		else
			self::$m_format = 'txt';


		if(array_key_exists('filename', $params))
			self::$m_pathfile = $params['filename'];
		else
			self::$m_pathfile = $_SERVER['SERVER_NAME'];

		try {

			$tpl = file_get_contents( self::$m_pathfile );
			return $tpl;
		} catch(Exeption $e) {
			echo "Caught exception: " . $e->getMessage();
		}
	}
}