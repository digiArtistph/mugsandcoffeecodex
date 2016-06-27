<?php
/**
 * Added functionalities to image objects
 * @author Kenneth P. Vallejos
 * @since Friday, February 13, 2015
 *
 */

trait Jpgmethod {

	public function CreateNewImage ( $source ) {
		return $image = imagecreatefromjpeg( $source );
	}

	public function CompressImage ( $image, $destination, $quality = 60 ) {
		imagejpeg($image, $destination, $quality);

	}

}

trait Pngmethod {

	public function CreateNewImage ( $source ) {
		return $image = imagecreatefrompng( $source );
	}

	public function CompressImage ( $image, $destination, $quality = 7 ) {
		imagepng($image, $destination, $quality);

	}
	
}

trait Gifmethod {

	public function CreateNewImage ( $source ) {
		return $image = imagecreatefromgif( $source );
	}

	public function CompressImage ( $image, $destination, $quality = 60 ) {
		imagejpeg($image, $destination, $quality);

	}
	
}

trait CreateThumbMethod {

	public function CreateMethod ( $source ) {
		// Get new dimensions
		list($width, $height) = getimagesize($filename);
		$new_width = $width * $percent;
		$new_height = $height * $percent;

		// Resample
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// Output
		imagejpeg($image_p, null, 100);
	}
	
}