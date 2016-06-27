<?php

namespace alamid\classes;
/**
 * Includes all user-defined functions from each modules inside application/modules folder
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Tuesday, February 17, 2015
 * @version 1.0.1
 *
 */
use \DirectoryIterator;
class FunctionLoader {

	private $mModulePath = null;
	
	const EXT = ".php";
	const SOURCE_FILE = "functions";
	const MODULES_FOLDER = "modules";
	const SOURCE_FOLDER = "helpers";
	const SOURCE_PATH = "../../application";
	const DS = DIRECTORY_SEPARATOR;

	public function __construct() {

		$this->mModulePath =  realpath( __DIR__ . self::DS . self::SOURCE_PATH . self::DS . self::MODULES_FOLDER ); 
		$this->_scanModules();

	}

	private function _scanModules () {
		
		try {
			foreach (new DirectoryIterator( $this->mModulePath  ) as $fileInfo) {
			    if($fileInfo->isDot()) continue;

			    $module_folder_name = $fileInfo->getFilename() ;
			    // echo $module_folder_name . "<br>\n";
			    foreach (new DirectoryIterator( $this->mModulePath . self::DS . $module_folder_name ) as $spcModule ) {
			    	if( $spcModule->isDot() )
			    		continue;
			    	if( strtolower($spcModule->getFilename()) != self::SOURCE_FOLDER )
			    		continue;

			    	foreach (new DirectoryIterator( $this->mModulePath . self::DS . $module_folder_name . self::DS . $spcModule->getFilename() ) as $functionFile ) {
			    		if( $functionFile->isDot() )
			    			continue;

			    		if( strtolower($functionFile->getFilename()) != self::SOURCE_FILE . self::EXT )
			    			continue;

			    		// include the file.
			    		include $this->mModulePath . self::DS . $module_folder_name . self::DS . $spcModule->getFilename()  . self::DS . self::SOURCE_FILE . self::EXT;
			    	}
			    }
			}
			
		} catch (Exception $e) {
			echo $e->getMessage();			
		}

	}

}