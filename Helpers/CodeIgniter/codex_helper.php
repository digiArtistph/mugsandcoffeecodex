<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('code_generator')) {

	function code_generator($length = 10){
	
		if ($length <= 0)
		{
			return false;
		}
		
		$code = "";
		$chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		srand((double)microtime() * 1000000);
		for ($i = 0; $i < $length; $i++)
		{
			$code = $code . substr($chars, rand() % strlen($chars), 1);
		}
			return $code;
			
		}
	 
}