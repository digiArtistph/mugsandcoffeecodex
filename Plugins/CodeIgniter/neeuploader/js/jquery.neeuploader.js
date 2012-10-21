// JavaScript Document
/**
 *
 * 	AJAX-Like Multiple Uploader
 *
 *	@framework	PHP | JQuery | jQuery Plugin
 *	@author		Kenneth "digiArtist_ph" P. Vallejos
 *	@since		Sunday, January 29, 2012
 *	@version	1.1.2
 *
 *
 *	Required Files:
 *		1. jquery.js >>> (can be downloaded from http://jquery.com). or you can just link to CDN: https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js
 *		2. jquery.neeuploader.js >>> jquery plugin (custom made)
 *		3. Php scripts:	
 * 			a. For Codeigniter Framework
 * 				 i. ajxupload.php  (PUT THIS FILE IN application/controllers folder)
 *				ii. ajxupload_success_view.php (PUT THIS FILE IN application/views folder)
 *		4. jquery.neeuploader.css 
 *		5. lightbox-ico-loading.gif
 *		6. sprite_loader.png
 *		7. uploader_icon.png (this is OPTIONAL, you can have you own icon 35x40 pixel)
 *		
 *		Note: THE ABOVE REQUIRED FILE ARE AVAILABLE IN 'neeuploader' FOLDER. and the 'neeuploader' folder should be placed on the the following path: '/SITEFOLDER/plugins'.  
 *
 *		Folder Sturcture:
 *   		+_SITE FOLDER
 *			|_plugins
 *			|	|_neeuploader
 *			|_application
 *			|_css
 *			|_js	
 *			|_images
 *
 *
 *
 *		NEEUPLOADER PLUGIN PARAMETERS:	
 *			max_width		-> (optional), maximum width of the image should be uploaded
 *			max_height 		-> (optional), maximum height of the image should be uploaded
 *			script 			-> (optional), a relative path, where your php script (ajxupload.php e.g.: './ajxupload/do_upload') resides.
 *			upload_path		-> (optional), a relative path, where your images on the server should be uploaded into. note: make sure to create an 'thumbs' folder inside the upload_path folder and don't forget to make those folders writable
 *			tooltip_delete	-> (optional), this is a message be displayed when you mouse over on the delete icon on the list item of the images
 *			tooltip_upload	-> (optional), this ia a message be displayed when you mouse over on the upload button of the plugin
 *			header_icon		->	(optional), TRUE|FALSE, default is TRUE. this will toggle the icon: visible or hidden.
 *			icon_path		-> (optional), this is the path of the image, which will appear besides on the header caption. you can have you own header icon (it should be 35 x 40px)
 *			header_footnote	-> (optional), this is a small caption that should apper underneath the bigger caption
 *			header_caption	-> (optional), this is a caption that should appear on the header of the plugin
 *			
 *
 *
 *
 *      =======================================================================================================================================================
 *		SAMPLE CODE
 *  	=======================================================================================================================================================
 *
 *		{HTML FILE}
 *			
 *			...
 *				<head>
 *					<link type="text/css" rel="stylesheet" href="http://newcastle-hunter-directory.com/uploader/plugins/neeuploader/css/jquery.neeuploader.css" />
 *					<script type="text/javascript" src="http://newcastle-hunter-directory.com/uploader/js/jquery.js"></script>
 *					<script type="text/javascript" src="http://newcastle-hunter-directory.com/uploader/plugins/neeuploader/js/jquery.neeuploader.js"></script>
 *
 *					<script type="text/javascript">
 *							$(function(){		
 *									$('#file_uploader').neeuploader({max_width: 2500, upload_path: 'newuploads/', max_height: 2500, header_caption: 'Select Files', header_footnote: 'Please click the upload button to select files.', header_icon: true});
 *		
 *							});
 *					</script>
 *				</head>
 *
 *			<body>
 *				<form action="./home/do_upload" method="post">
 *					<labe>Full Name: </labe><input type="text" name="fname" />
 *					<div id="file_uploader"></div>
 * 					<input type="submit" value="Submit" />
 *				</form>
 *  			</body>
 *			...
 *
 *
 *		{CONTROLLER}
 *
 *
 *		class Home extends CI_Controller {
 *     		function do_upload()
 *			{
 *				call_debug($_POST, FALSE);
 *				$arr = explode(',', $this->input->post('file_uploader_images'));
 *				
 *				>>> DO FORM/DATA PROCESSING/VALIDATION HERE <<<
 *				echo 'ci:<br />';
 *				
 *				call_debug($arr, FALSE);
 *			}
 *		}
 *		
 *		NOTE: 
 *			When getting the POST/GET variable for this plugin. Use the following:
 *			
 *				Codeigniter:
 *					$this->input->post('file_uploader_images');
 *		
 *				Raw Php:
 *					$_POST['file_uploader_images'];
 *
 *					
 */
(function($){
	// global variables
	var arrCache = new Array();
	
	$.fn.neeuploader = function(options) {
		var settings = $.extend({
			header_caption	:	'Select Files',
			header_footnote	:	'Add files through clicking the upload button',
			icon_path		:	'../images/uploader_icon.png',
			gauge_path		:	'./plugins/neeuploader/images/uploader_icon.gif',
			header_icon		:	true,
			tooltip_upload	:	'Click to upload file',
			tooltip_delete	:	'Delete file',
			upload_path		:	'uploads/',
			script			:	'./ajax/ajxupload/do_upload',
			create_thumbs	:	true,
			max_width		:	250,
			max_height		:	250
		}, options);
		
		// preps the string settings into array strings and pass to php script
		var strSettings = '';
		
		for(prop in settings) {
			strSettings += prop + '=' + settings[prop] + ',';
		}			
		
		//console.log(strSettings);
		var pattern = /.,$/;
		
		if(pattern.test(strSettings))
			strSettings = strSettings.substr(0, strSettings.length-1);
		/* --- end --- */
		
		
		$(this).append('<input type="hidden" id="file_uploader_images" name="file_uploader_images" />');
		
		$('body').append('<div id="mfile_uploader"></div>');
				
		$('#mfile_uploader').append('<form action="' + settings.script + '" method="post" accept-charset="utf-8" id="frmupload" target="upload_target" enctype="multipart/form-data"><input type="hidden" name="settings" value="' + strSettings + '" /><input name="file[]" type="file" id="file" size="1" /></form>');
		$('#mfile_uploader').append('<div class="uploadbox"></div>');
		$('.uploadbox').append('<div class="uploadboxcaption">' + (settings.header_icon==true? '<img src="' + settings.icon_path + '" class="sprite_loader header_icon" />' : '') + settings.header_caption + '<p class="footnote">' + settings.header_footnote + '</p></div>');
		
		$('.uploadbox').append('<div upload="' + settings.tooltip_upload + '" delete="' + settings.tooltip_delete +  '" class="tooltip">This is a tooltip</div>');
		
		$('.uploadbox').append('<div class="uploadboxheader"><div class="colone">Filename</div><div class="coltwo">Size</div><div class="colthree">Status</div><div class="colfour">Action</div></div><div class="clearthis" />');
		$('.uploadbox').append('<ul class="uploadboxlist">');
		
		$('.uploadbox').append('<div class="clearthis" />');
        $('.uploadbox').append('<div class="uploadboxfooter"><a class="sprite_loader" id="uploadbtn" href="#" >Upload</a><p class="image_count">0 image</p><div class="gauge"><p>Uploading...</p><img src="' + settings.gauge_path + '" /></div></div>');
		$('#mfile_uploader').append('<iframe name="upload_target" id="upload_target" style="width:0; height:0;"></iframe>');
	
		
		$('#uploadbtn').bind('click', displayMsg);
		//$('#msgbtn').bind('click', displayMsg);
		$('form #file').bind('change', autoSubmitForm);
		
		function displayMsg() {
			$('form #file').trigger('click');
			return false;
		}
		
		
		function autoSubmitForm() {
			//alert('The form has been submitted automatically');	
			// shows the animation icon
			$('.gauge').css('visibility', 'visible');
			$('#frmupload').submit();

			return false;
		}
		
		// tooltip's hover
		$('#uploadbtn, #file').mousemove(function(e){
			var tooltip = $('.tooltip');
			
			tooltip.text(tooltip.attr('upload'));
			// shows the tooltip.
			tooltip.css({'display':'block'});
			// default position of the tooltip
			tooltip.offset({top: e.pageY + 2, left: e.pageX + 10});
		})
		.mouseout(function(){
			var tooltip = $('.tooltip');
			
			// hides the tooltip.
			tooltip.css({'display':'none'});

		});

		// some utility checks
		// ie tweaks
		if($.browser.msie)
			$('#mfile_uploader #frmupload #file').css({'border' : 'none', 'left' : '-20px', 'position' : 'absolute', 'top' : '240px', 'z-index' : '9999', 'filter' : 'alpha(opacity=0)', 'cursor' : 'pointer'});
		else
			$('#mfile_uploader #frmupload #file').css({'border' : 'none', 'left' : '10px', 'position' : 'absolute', 'top' : '10px'});
		
		var pluginCntr = $(this).offset();
		
		$('#mfile_uploader').css({top: pluginCntr.top, left: pluginCntr.left});			
	}
})(jQuery);

function displayResult(strDom, strFilename) {
	// hides the animation icon
	$('.gauge').css('visibility', 'hidden');
	
	// adds filename to the current form
	var fuImages = $('#file_uploader_images');			
	fuImages.attr('value', appendAttrib(fuImages, strFilename/*$('#file').attr('value')*/));
	
	console.log('fuImages: ' +  fuImages.attr('value'));
	
	// clears current value of input type="file"
	$('#file').attr({'value': ''});	
	//console.log('file: ' +	$('#file').attr('value'));
	
	// adds item on the lists of uploaded file
	$('.uploadboxlist').append(strDom);		
	// check if the file has been succesfully uploaded
	// 	if true then get files from the div, then call writedata function
	
	// unbinds from all handlers
	$('.uploaderdeleteicon').unbind();
	
	// binds again to handler to all elements
	$('.uploaderdeleteicon').bind('click', function() {	
		var retainedImgs = '';
			
		// removes the selected item list
		$(this).parent().parent().remove();
		// get the removed itme, reads data
		// update data
		

		$('.colone').each(function(){
			if($(this).text() != 'Filename')
				retainedImgs += $(this).text() + ',';
		});
		
		var pattern = /.,$/;
		

		if(pattern.test(retainedImgs))
			retainedImgs = retainedImgs.substr(0, retainedImgs.length-1);
		
		$('#file_uploader_images').attr('value', retainedImgs);
		//console.log($('#file_uploader_images').attr('value'));
		// $(this).parent().parent()).text();
		
		$('#mfile_uploader .uploadbox .uploadboxfooter .image_count').text('0 image');
		$('#mfile_uploader .uploadbox .uploadboxlist li .colone').each(function(index){				
			$('#mfile_uploader .uploadbox .uploadboxfooter .image_count').text(index+1 + ((index+1) >= 2 ? ' images' : ' image'));		
		});
		
		return false;
	})
	.bind('mouseover', function(e){
		var tooltip = $('.tooltip');
		
		tooltip.text(tooltip.attr('delete'));
		
		// shows the tooltip.
		tooltip.css({'display':'block'});
		// default position of the tooltip
		tooltip.offset({top: e.pageY + 2, left: e.pageX + 10});
		
	})
	.bind('mouseout', function(){
		var tooltip = $('.tooltip');
		
		// hides the tooltip.
		tooltip.css({'display':'none'});
	});
	
	
	// increments the counter of the images uploaded
	$('#mfile_uploader .uploadbox .uploadboxlist li .colone').each(function(index){				
		$('#mfile_uploader .uploadbox .uploadboxfooter .image_count').text(index+1 + ((index+1) >= 2 ? ' images' : ' image'));		
	});
	
	$('.uploadboxlist li:odd').css({'background' : '#efefef'});
	
}

function appendAttrib(obj, nVal) {
	var curVal = '';

	curVal += obj.attr('value');
	
	if(obj.attr('value') != '')
		curVal += ',' + nVal;
	else
		curVal += nVal;		

	return curVal;
}


