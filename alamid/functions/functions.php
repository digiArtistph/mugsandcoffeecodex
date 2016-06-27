<?php
/**
 *
 * This will load user-defined functions first. afterwards, the system default functions for the (alamid) hooks
 *
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Tuesday, February 17, 2015
 * @version 1.3.0
 *
 */


// DO NOT REMOVE THE TWO FOLLOWING LINES OF CODES
require_once __DIR__ . DIRECTORY_SEPARATOR . "../classes/FunctionLoader.php";
use alamid\classes\FunctionLoader;

// ============================ >>> WIKI <<< ====================================
/**
 *
 *	NOTE:	To attach your user-defined function with one of the following hooks. You need to create a "functions.php"
 *			file inside the "helpers" folder, which is located under your HMVC module folder.
 * 			ex. widgetAccordion module
 *				/application/modules
 *				--+ controllers
 *				  + models
 *  			  + views
 *  			  + helpers
 *				  --> functions.php
 *
 *	OVERRIDE:
 *			If you want to override the system's default hook function, then create a function with
 *				the same inside the module's helper folder.
 *	
 *
 * A.	Builds the front-end sidebar
 * 		HOOK: left_sidebar_section
 *		function: build_sidebar()
 * 		example:
 *			tail_on(<HOOK>, <your-user-defined-function> );
 *
 *			tail_on( "left_sidebar_section", <function() { <block of php/html/css/php codes> }>); // anonymous function
 *
 * B. 	Builds the dashboar-profile sidebar
 * 		HOOK: user_dashboard_sidebar_section
 *		function: build_user_dashboard_sidebar()
 * 		example:
 *			tail_on(<HOOK>, <your-user-defined-function> );
 *
 * 			tail_on( "user_dashboard_sidebar_section", <your-user-defined-function>);
 *			function <your-user-defined-function> () { <block of php/html/css/php codes> }
 *
 * C.	Builds the Admin section sidebar`
 * 		HOOK: admin_dashboard_sidebar_section
 *		function: build_admin_dashboard_sidebar()
 * 		example:
 *			tail_on(<HOOK>, <your-user-defined-function> );
 *
 *			tail_on( "left_sidebar_section", <function() { <block of php/html/css/php codes> }>); // anonymous function
 *
 *
 */



/**
 * ==============================================================================
 * ==============================================================================
 *              >>> DO NOT EDIT CODES BEYOND THIS LINE <<<
 * ==============================================================================
 * ==============================================================================
 *
 */


new FunctionLoader();
// ==============================================================================
//  HOOKS SECTION
// ==============================================================================

// ==============================================================================
// START FRONT-END SIDEBAR SECTION HERE
tail_on( "left_sidebar_section", "build_sidebar"); 
if( !function_exists("build_sidebar") ) {
	function build_sidebar() {
		// do not edit this function
	}
}
// END FRONT-END SIDEBAR SECTION HERE
// ==============================================================================

// ==============================================================================
// START ADMIN SECTION HERE

tail_on( 'admin_dashboard_sidebar_section', 'build_admin_dashboard_sidebar' );
if( ! function_exists("build_admin_dashboard_sidebar") ) {
	function build_admin_dashboard_sidebar () {
		$CI =& get_instance();
		$section = $CI->uri->segment(2);
		$subSection = $CI->uri->segment(3);

		// ===================================
		// OVERRIDES SIDEBAR'S SETTINGS
		// ===================================
		switch ( $section) {
			case "validate_change_password":
				$section = "profile";
				$subSection = "changepassword";
				break;
		}

		?>
		<div class="tab_container">
			<div class="accord">
				<dl data-accordion="" class="accordion">	
				
							<dd>
								<a href="#panel1" id="padtab"><i id="imahe1"></i>Summary</a>
							
								<div class="content <?php echo setActive($section,'summary'); ?>" id="panel1">
									<ul class="side-nav">
										<li <?php echo setActive($subSection,'dashboard', true); ?>><a href="<?php echo base_url('admin/summary/dashboard'); ?>" id="submenu">Dashboard</a></li>
									</ul>					
								</div>
							</dd>
						
							<dd>
								<a href="#panel2"  id="padtab"><i id="imahe2"></i>Reports</a>
													
								<div class="content <?php echo setActive($section,'reports'); ?>" id="panel2">
									<ul class="side-nav">
										<li <?php echo setActive($subSection,'users', true); ?>><a href="<?php echo base_url('admin/reports/users'); ?>" id="submenu">Users</a></li>
										<li <?php echo setActive($subSection,'listings_active', true); ?>><a href="<?php echo base_url('admin/reports/listings_active'); ?>" id="submenu">Active Listings</a></li>
										<li <?php echo setActive($subSection,'listings_expired', true); ?>><a href="<?php echo base_url('admin/reports/listings_expired'); ?>" id="submenu">Expired Listings</a></li>
										<li <?php echo setActive($subSection,'categories', true); ?>><a href="<?php echo base_url('admin/reports/categories'); ?>" id="submenu">Categories</a></li>
									</ul>					
								</div>
								</dd>
								
							<dd >
								<a href="#panel3"  id="padtab"><i id="imahe3"></i>Utilities</a>
								
								<div class="content <?php echo setActive($section,'utilities'); ?>"  id="panel3">
									<ul class="side-nav">
										<li <?php echo setActive($subSection,'backup', true); ?>>
										<a href="<?php echo base_url('admin/utilities/backup'); ?>" id="submenu">Backup</a></li>
										<!-- <li <?php echo setActive($subSection,'chatbox', true); ?>><a href="<?php echo base_url('admin/utilities/chatbox'); ?>">Chatbox</a></li> -->
									</ul>
								</div>
							</dd>
								
							<dd>
								<a href="#panel4"  id="padtab"><i id="imahe4"></i>Settings</a>
								<div class="content <?php echo setActive($section,'settings'); ?>"  id="panel4">
									<ul class="side-nav">
										<li <?php echo setActive($subSection,'general', true); ?>>
										<a href="<?php echo base_url('admin/settings/general'); ?>" id="submenu">General</a></li>
									</ul>
								</div>
							</dd>
						<p>&nbsp;</p>
			<p><img src="http://placehold.it/320x240&text=Ad"/></p>
					</dl>
			
			</div>
			</div>
			


		<?php
	}
}
// END ADMIN SECTION HERE
// ==============================================================================



// ==============================================================================
// START DASHBOARD SECTION HERE

tail_on('user_dashboard_sidebar_section', 'build_user_dashboard_sidebar');
if(!function_exists("build_user_dashboard_sidebar")) {
	function build_user_dashboard_sidebar() {
		$CI =& get_instance();
		$section = $CI->uri->segment(2);
		$subSection = $CI->uri->segment(3);

		// ===================================
		// OVERRIDES SIDEBAR'S SETTINGS
		// ===================================
		switch ( $section) {
			case "validate_change_password":
				$section = "profile";
				$subSection = "changepassword";
				break;
		}

		?>
		<dl data-accordion="" class="accordion">	
		
				<dd class="">
					<a href="#panel1">Profile</a>
					<div class="content <?php echo setActive($section,'profile'); ?>" id="panel1">
						<ul class="side-nav">
							<li <?php echo setActive($subSection,'pinfo', true); ?>><a href="<?php echo base_url('dashboard/profile/pinfo'); ?>">Personal Info</a></li>
							<li <?php echo setActive($subSection,'changepassword', true); ?>><a href="<?php echo base_url('dashboard/profile/changepassword'); ?>">Change Password</a></li>
							<li <?php echo setActive($subSection,'paymenthistory', true); ?>><a href="<?php echo base_url('dashboard/profile/paymenthistory'); ?>">Invoice</a></li>
							<li <?php echo setActive($subSection,'settings', true); ?>><a href="<?php echo base_url('dashboard/profile/settings'); ?>">Settings</a></li>
						</ul>					
					</div>
				</dd>
				<dd>
					<a href="#panel2">Messages</a>
					<div class="content <?php echo setActive($section,'messages'); ?>" id="panel2">
						<ul class="side-nav">
							<li <?php echo setActive($subSection,'inbox', true); ?>><a href="<?php echo base_url('dashboard/messages/inbox'); ?>">Inbox</a></li>
							<li <?php echo setActive($subSection,'sent', true); ?>><a href="<?php echo base_url('dashboard/messages/sent'); ?>">Sent</a></li>
							<li <?php echo setActive($subSection,'draft', true); ?>><a href="<?php echo base_url('dashboard/messages/draft'); ?>">Draft</a></li>
							<li <?php echo setActive($subSection,'trash', true); ?>><a href="<?php echo base_url('dashboard/messages/trash'); ?>">Trash</a></li>
						</ul>					
					</div>
				</dd>
				<dd>
					<a href="#panel3">Listings</a>
					<div class="content <?php echo setActive($section,'listings'); ?>"  id="panel3">
						<ul class="side-nav">
							<li <?php echo setActive($subSection,'active', true); ?>>
							<a href="<?php echo base_url('dashboard/listings/active'); ?>">Active</a></li>
							<li <?php echo setActive($subSection,'expired', true); ?>><a href="<?php echo base_url('dashboard/listings/expired'); ?>">Expired</a></li>
							<!-- <li <?php echo setActive($subSection,'saved', true); ?>><a href="<?php echo base_url('dashboard/listings/saved'); ?>">Saved</a></li> -->
						</ul>
					</div>
				</dd>
			<p>&nbsp;</p>
			<p><img src="http://placehold.it/320x240&text=Ad"/></p>
		</dl>
		<?php
	}
}


function setActive($section, $current, $incClass = false) {
	if($incClass) {
		if($section == $current)
			return ' class="active" ';
		else
			return "";
	} else {
		if($section == $current)
			return " active ";
		else
			return "";
	}

}

// END DASHBOARD SECTION HERE
// ==============================================================================


// ==============================================================================
// START THE_POSTROLL HERE
tail_on( "the_postroll", "fetch_roll", 0 );
if( !function_exists("fetch_roll") ) {
	function fetch_roll() {	
		// do AJAX here
	}
}

// END THE_POSTROLL SECTION HERE
// ==============================================================================



// ==============================================================================
// autimatically loads uninclued classes/interfaces
// ==============================================================================
// Note: spl_autoload_register method and __autoload magic functon are having
// 		 	issues with CodeIgniter loader object. Better yet to use require,
// 			require_once, include, or include_once functions
// function autoload($className) {
// 	$className = ltrim($className, '\\');
// 	$fileName  = '';
// 	$namespace = '';
// 	if ($lastNsPos = strrpos($className, '\\')) {
// 		$namespace = substr($className, 0, $lastNsPos);
// 		$className = substr($className, $lastNsPos + 1);
// 		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
// 	}
// 	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

// 	require $fileName;
// }