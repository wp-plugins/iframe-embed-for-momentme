<?php
/*
Plugin Name: IFRAME Embed For Moment.me (IEFM)
Plugin URI: http://plugins.moment.me/wp/iframe-embed-for-Momentme.zip
Description: IFRAME Embed For Moment.me - Enrich the content of your website by embeding Moment.me photo stream in an Iframe , you only need to input the URL of the moment you like. Check <a href = "http://moment.me/moments/trending" target="_blank"> Moment.me trending moments </a> for a wide selection of free images and content from worldwide events.
Version: 1.44	
Author: Moment.me
Author URI: http://moment.me
WordPress version supported: 2.7 and above
License: GPLv2 or later
*/

function iefm_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}
//on activation, your IFRAME Embed For Moment.me options will be populated. Here a single option is used which is actually an array of multiple options
function activate_iefm() {
	$iefm_opts1 = get_option('iefm_options');
	$iefm_opts2 =array('width' => '640',
	                   'height' => '385',
					   'support' => '0');
	if ($iefm_opts1) {
	    $iefm = $iefm_opts1 + $iefm_opts2;
		update_option('iefm_options',$iefm);
	}
	else {
		$iefm_opts1 = array();	
		$iefm = $iefm_opts1 + $iefm_opts2;
		add_option('iefm_options',$iefm);		
	}
}

register_activation_hook( __FILE__, 'activate_iefm' );
global $iefm;
$iefm = get_option('iefm_options');
define("iefm_VER","1.0",false);
define('iefm_URLPATH', trailingslashit( WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) ) );
include_once (dirname (__FILE__) . '/tinymce/tinymce.php');
//External CSS in the header
function iefm_scripts_styles() {
global $iefm;
	wp_enqueue_style( 'iefm_css_file', iefm_url( 'css/iefm.css' ),
		false, iefm_VER, 'all'); 
}
// add_action( 'init', 'iefm_scripts_styles' );

function iefm_get_moment_iframe($moment_url,$width, $height) {
	preg_match('@moment.me/n/(\d*)@i',$moment_url, $matches);
	$qstring = $matches[1];      
	$code = null;
	if($qstring != '' and isset($qstring) and $qstring != 0) {		
		$code = '<iframe width="'.$width.'" height="'.$height.'" src="http://cdn.moment.me/embed/'.$qstring.'" frameborder="0" type="text/html"></iframe>';		
	}
	return $code;	
}

// [mframe url="moment url"]
function iefm_mframe_shortcode($atts) {
	global $iefm;
	extract(shortcode_atts(array(
		'url' => 'abc',
		'width' => $iefm['width'],
		'height' => $iefm['height'],
	), $atts));
	
	$insert_code=iefm_get_moment_iframe($url, $width, $height);
    global $iefm;
	return $insert_code;
}
add_shortcode('mframe', 'iefm_mframe_shortcode');

// function for adding settings page to wp-admin
function iefm_settings() {
    // Add a new submenu under Options:
    add_options_page('IFRAME Embed For Moment.me', 'IFRAME Embed For Moment.me', 9, basename(__FILE__), 'iefm_settings_page');
}

function iefm_admin_head() {?>
<style type="text/css">
#divFeedityWidget span {
        display:none !important;
}
#divFeedityWidget a{
        color:#06637D !important;
}
#divFeedityWidget a:hover{
		font-size:110%;
}
</style>
<?php }

add_action('admin_head', 'iefm_admin_head');
// This function displays the page content for the IFRAME Embed For Moment.me Options submenu
function iefm_settings_page() {
?>
<div class="wrap">
<h2>IFRAME Embed For Moment.me</h2>
<div style="clear:both;"></div>
<form  method="post" action="options.php">
<div id="poststuff" class="metabox-holder has-right-sidebar"> 

<div style="float:left;width:55%;">
<?php
settings_fields('iefm-group');
$iefm = get_option('iefm_options');
?>
<h2>Dimensions of the Moment Iframe</h2> 
<p>Enter the dimensions of the Moment.me iframe - depending upon the width of your Wordpress theme</p> 

<table class="form-table">

<tr valign="top">
<th scope="row"><label for="iefm_options[width]">Width</label></th> 
<td><input type="text" name="iefm_options[width]" class="small-text" value="<?php echo $iefm['width']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row"><label for="iefm_options[height]">Height</label></th> 
<td><input type="text" name="iefm_options[height]" class="small-text" value="<?php echo $iefm['height']; ?>" />&nbsp;px</td>
</tr>

</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</div>

   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About this Plugin:</span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="http://moment.me/embed" title="Moment.me Embed" >Moment.me embed feature</a></li>
                <li><a href="http://moment.me" title="Visit Moment.me" >Plugin Parent Site</a></li>
                <li><a href="http://moment.me/moments/trending" title="Moment.me trending moments" >A wide selection of free content from live shows festivals and sports events</a></li>
                </ul> 
              </div> 
			</div> 
     </div>

       
</div> <!--end of poststuff -->

</form>
</div> <!--end of float wrap -->
<?php	
}
// Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'iefm_settings');
  add_action( 'admin_init', 'register_iefm_settings' ); 
} 
function register_iefm_settings() { // whitelist options
  register_setting( 'iefm-group', 'iefm_options' );
}

?>