<?php
/**
 * Manages image file of png type
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Friday, September 5, 2014
 * @version 1.0.0
 * @param resource An image file
 *
 */
class PngImage implements IImage {

	use ImageProperties, Pngmethod;

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