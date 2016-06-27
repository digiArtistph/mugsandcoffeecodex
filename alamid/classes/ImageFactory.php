<?php
/**
 * Returns a specific type of image object
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Friday, September 5, 2014
 * @version 1.0.0
 * @param resource An image file
 *
 */
class ImageFactory {

	public static function factory ( $source ) {

		$info = getimagesize( $source );
		$type = preg_split("/\//", $info[ 'mime' ] );
		$type = $type[ 1 ];

		switch ( strtolower($type) ) {
			case 'jpg':
			case 'jpeg':
				return new JpgImage();
			case 'gif':
				return new GifImage();
			case 'png':
				return new PngImage();
			defaul:
				return null;
		}
	}
}