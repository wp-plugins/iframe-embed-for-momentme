<?php

// look up for the path
require_once( dirname( dirname(__FILE__) ) . '/iefm-config.php');
// check for rights
if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here"));

global $wpdb;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Iframe Embed For Moment.me</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo iefm_URLPATH ?>tinymce/tinymce.js"></script>
	<base target="_self" />
</head>
<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('momenturl').focus();" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="IEFM" action="#">
	
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="momenturl">Enter Moment URL</label></td>
            <td><input type="text" id="momenturl" name="momenturl" value="http://moment.me/n/906261" size="50" /></td>
          </tr>
		  
		  <tr>
			<td nowrap="nowrap">
				<strong>Width</strong>
				<input id="momentWidth" name="momentWidth" type="text" class="text" size="3" value="500">
			</td>
            <td nowrap="nowrap">
				<strong>Height</strong>
				<input id="momentHeight" name="momentHeight" type="text" class="text" size="3" value="300">
			</td>
          </tr>
		  
        </table>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onClick="insertIEFMLink();" />
		</div>
	</div>
	
	<br />
	<br />
	<div>
		<br />
		<a href = "http://moment.me/moments/trending" target="_blank" style="color: rgb(0,0,255)" > Click here to select a Moment to embed! </a>
	
	</div>
</form>
</body>
</html>