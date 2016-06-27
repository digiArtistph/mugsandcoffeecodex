<?php

class DoImageWatermark {

	public function execute ( $stamp_img = '', $main_img = '', $name = '') {
		// image object for main image
		$image = ImageFactory::factory( $this->get_upload_file_type( $main_img ) );
		$image->hard_initialize( $main_img );

		// image object for stamp image
		$obj_img_stamp  = ImageFactory::factory( $this->get_file_type( $stamp_img ) );
		$obj_img_stamp->initialize( $stamp_img );

		// creates image resource for main image
		$big_img = $this->create_image( $image->getFile_type(), $image->getPath(), $image->getFilename() );

		// craete image resource for stamp image
		$overlay_img = $this->create_image( $obj_img_stamp->getFile_type(), $obj_img_stamp->getPath(), $obj_img_stamp->getFilename() );
		
		// enables blending mode of two images
		imagealphablending( $big_img, true );
		
		// on_watch(imagesx( $overlay_img ));
		imagecopymerge($big_img, $overlay_img, ( $image->getWidth() - (150 + 10) ), ( $image->getHeight() - (34 + 10) ), 0, 0, imagesx( $overlay_img ), imagesy( $overlay_img ), 20);

		// creates the composite image
		return $this->create_final_image($image->getFile_type(), $big_img, "uploads/", $name );

	}

	private function create_final_image ( $type, $image, $path, $filename = '' ) {
		$filename = ($filename != "") ? $filename : md5(microtime( true ));
		switch ( $type ) {
			case 'jpg':
				imagejpeg( $image, "$path/$filename.jpg" );
				return "$path/$filename.jpg";
			case 'png':
				imagepng( $image, "$path/$filename.png" );
				return "$path/$filename.png";
			case 'gif':
				imagegif( $image, "$path/$filename.gif" );
				return "$path/$filename.gif";
			default:
				return null;
		}
	}

	private function create_image ( $type, $path, $filename ) {
		switch ( $type ) {
			case 'jpg':
				return imagecreatefromjpeg("$path/$filename");
			case 'png':
				return imagecreatefrompng("$path/$filename");
			case 'gif':
				return imagecreatefromgif("$path/$filename");
			default:
				return null;
		}
	}

	private function get_file_type ( $img ) {
		$path_part = pathinfo( $img );
		return $path_part[ 'extension' ];
	}

	private function get_upload_file_type ( $img ) {
		$info = getimagesize( $img );
		return $this->get_standard_file_type( $this->get_mime_type( $info[ 'mime'] ));

	}

	private function get_mime_type ( $type ) {
		$pattern = '/(?<=\/)[a-zA-Z]+$/';
		preg_match($pattern, $type, $matches);

		return $matches[0];

	}

	private function get_standard_file_type ( $type ) {
		switch ( $type ) {
			case 'jpeg':
			case 'jpg':
				return 'jpg';
			case 'gif':
				return 'gif';
			case 'png':
				return 'png';
		}

	}
}