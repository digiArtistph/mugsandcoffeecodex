<?php
/**
 * Manages image file of jpg type
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Friday, September 5, 2014
 * @version 1.0.0
 * @param resource An image file
 *
 */
class JpgImage implements IImage {

	use ImageProperties, Jpgmethod;

	private $mImageObject = null;
	private $mImageProperties = null;

	public function __construct() {
		// echo "Initiating JpgImage class...<br/>";

	}

	public function initialize ( $source, $upload = false, $mixed = array() ) {
		$this->mImageObject = $source;

		if( $upload )
			$this->mImageProperties = $mixed;

		return $this->mImageObject;

	}

	public function getImageProperties () {
		return $this->mImageProperties;

	}

}