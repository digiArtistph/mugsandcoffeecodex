<?php if(! defined('BASEPATH')) exit('No direct script access allowed.');

class Ajxupload extends CI_Controller {
	
	public function test() {		
		call_debug($_POST, TRUE);

	}
	
	function do_upload()
	{
		// loads codex helper
		$this->load->helper('codex');

		// preps string into array
		$xplode = explode(',',$this->input->post('settings'));
		$options = array();
		
		//call_debug($xplode,FALSE);
		foreach ($xplode as $elem):
			$xplodemore = explode('=',$elem);
			$options[$xplodemore[0]] = $xplodemore[1];
		endforeach;
		
		//call_debug($options, FALSE);
		$config = array	(
							'upload_path' => 'uploads/',
							'allowed_types' => 'gif|jpg|png',
							'max_size' => '55000',
							'max_width' => '2500',
							'max_filename' => 0,
							'max_height' => '2500',
							'file_name' => code_generator() . hash('md5', $_SERVER['REMOTE_ADDR'])
						);
		
		$newconfig = array_merge($config, $options);
		
		call_debug($newconfig, true);

		$this->load->library('multipleupload', $newconfig);
		
		if(! $this->multipleupload->do_upload()) {
			$data['errors'] = $this->multipleupload->display_errors();
			$data['file_data'] = $this->multipleupload->_mAPIError;
			$this->load->view('ajax/ajxupload_success_view', $data);
		} else {		
			$data['file_data'] = $this->multipleupload->data();
			$this->load->view('ajax/ajxupload_success_view', $data);
		}
	}
	
}