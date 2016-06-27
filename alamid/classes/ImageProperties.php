<?php
/**
 * Added functionalities to image objects
 * @author Kenneth P. Vallejos
 * @since Friday, February 13, 2015
 *
 */
trait ImageProperties {
		
	public function getHeight ( ) {

		return intval( $this->getImageInfo()[1] );
	}

	public function getWidth () {
		return intval( $this->getImageInfo()[0] );
	}

	public function getFileType () {
		return strval( $this->get_mime_type( $this->getImageInfo()['mime'] )); 
	}

	public function getFileName () {
		$properties = $this->getImageProperties();

		if( empty( $properties ) || null == $properties )
			return "No name";
			
		if( ! array_key_exists( "name", $properties) )
			return "No name";

		return $this->file_ext_strip( $properties[ 'name' ] );

	}

	public function getPath () {
		$properties = $this->getImageProperties();

		if( empty( $properties ) || null == $properties )
			return "No path";
			
		if( ! array_key_exists( "tmp_name", $properties) )
			return "No path";

		$path = pathinfo( $properties[ 'tmp_name' ] )[ 'dirname' ];

		return $path;

	}

	public function getImageObject () {
		return $this->mImageObject;

	}

	private function get_mime_type ( $type ) {
		$pattern = '/(?<=\/)[a-zA-Z]+$/';
		preg_match($pattern, $type, $matches);

		if( empty($matches) )
			return "";

		if( strtolower( $matches[ 0 ]) == "jpeg" )
			return "jpg";

		return strtolower( $matches[0] );

	}

	private function getImageInfo() {
		return $info = getimagesize( $this->mImageObject);
	}


	/**
	 * @author Cory LaViska
	 * @url http://www.abeautifulsite.net/php-functions-to-get-and-remove-the-file-extension-from-a-string/
	 * @url https://twitter.com/intent/follow?original_referer=http%3A%2F%2Fwww.abeautifulsite.net%2Fphp-functions-to-get-and-remove-the-file-extension-from-a-string%2F&region=follow_link&screen_name=claviska&tw_p=followbutton
	 */
	private function file_ext_strip( $filename ){
		return preg_replace( '/.[^.]*$/', '', $filename );

	}

} /* end trait ImageProperties */