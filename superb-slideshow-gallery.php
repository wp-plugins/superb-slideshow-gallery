<?php

/*
Plugin Name: Superb slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
Description: is a strong cross browser fade in slideshow script that incorporates some of your most requested features all rolled into one. Each instance of a fade in slideshow on the page is completely independent of the other, with support for different features selectively enabled for each slide show.  
Author: Gopi.R
Version: 10.0
Author URI: http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
Donate link: http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
*/

global $wpdb, $wp_version;
define("WP_ssg_TABLE", $wpdb->prefix . "ssg_superb_gallery");

function ssg_show() 
{
	global $wpdb;
	$ssg_package = "";
	$ssg_width = get_option('ssg_width');
	$ssg_height = get_option('ssg_height');
	$ssg_pause = get_option('ssg_pause');
	$ssg_fadeduration = get_option('ssg_fadeduration');
	$ssg_descreveal = get_option('ssg_descreveal');
	$ssg_cycles = get_option('ssg_cycles');
	$ssg_random = get_option('ssg_random');
	$ssg_type = get_option('ssg_type');
	
	if(!is_numeric(@$ssg_width)) {	@$ssg_width = 250;	} 
	if(!is_numeric(@$ssg_height)) {	@$ssg_height = 200;	}
	if(!is_numeric(@$ssg_pause)) {	@$ssg_pause = 2500;	}
	if(!is_numeric(@$ssg_fadeduration)) { @$ssg_fadeduration = 500; }
	if(!is_numeric(@$ssg_cycles)) {	@$ssg_cycles = 0;	}
	
	$sSql = "select ssg_path,ssg_link,ssg_target,ssg_title from ".WP_ssg_TABLE." where 1=1";
	$sSql = $sSql . " and ssg_type='".$ssg_type."'";
	if($ssg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY ssg_order"; }
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$ssg_package = $ssg_package .'["'.$data->ssg_path.'", "'.$data->ssg_link.'", "'.$data->ssg_target.'", "'.$data->ssg_title.'"],';
		}
	}	
	$ssg_package = substr($ssg_package,0,(strlen($ssg_package)-1));
	?>
	<script type="text/javascript">
	var mygallery=new SuperbSlideshowGallery ({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [<?php echo $ssg_width; ?>, <?php echo $ssg_height; ?>], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [ <?php echo $ssg_package; ?> ],
	displaymode: {type:'auto', pause:<?php echo $ssg_pause; ?>, cycles:<?php echo $ssg_cycles; ?>, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: <?php echo $ssg_fadeduration; ?>, //transition duration (milliseconds)
	descreveal: "<?php echo $ssg_descreveal; ?>",
	togglerid: ""
	})
	</script>
	<div id="fadeshow1"></div>
    <?php
}

add_shortcode( 'ssg-superb-slideshow', 'ssg_shortcode' );

function ssg_shortcode($atts) 
{
	global $wpdb;

	// Old short code
	// $var = $matches[1];
	//[ssg-superb-slideshow=page=600=400=2500=500=0=YES] 
	
	// New short code
	//[ssg-superb-slideshow type="widget" width="250" height="165" pause="2500" fade="500" cycles="0" rand="YES"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$ssg_type = $atts['type'];
	$ssg_width = $atts['width'];
	$ssg_height = $atts['height'];
	$ssg_pause = $atts['pause'];
	$ssg_fadeduration = $atts['fade'];
	$ssg_cycles = $atts['cycles'];
	$ssg_random = $atts['rand'];
	
	$ssg_xml = "";
	$ssg_package = "";
	//list($ssg_type, $ssg_width, $ssg_height, $ssg_pause, $ssg_fadeduration, $ssg_cycles, $ssg_random) = split('[=.-]', $var);
	
	if($ssg_type==""){$ssg_type = "widget";}
	if(!is_numeric(@$ssg_width)) {	@$ssg_width = 250;	} 
	if(!is_numeric(@$ssg_height)) {	@$ssg_height = 200;	}
	if(!is_numeric(@$ssg_pause)) {	@$ssg_pause = 2500;	}
	if(!is_numeric(@$ssg_fadeduration)) { @$ssg_fadeduration = 500; }
	if(!is_numeric(@$ssg_cycles)) {	@$ssg_cycles = 0; }
	
	$ssg_descreveal = get_option('ssg_descreveal1');
	if( $ssg_descreveal == "")
	{
		$ssg_descreveal = "peek-a-boo";
	}
	
	$sSql = "select ssg_path,ssg_link,ssg_target,ssg_title from ".WP_ssg_TABLE." where 1=1";
	$sSql = $sSql . " and ssg_type='".$ssg_type."'";
	if($ssg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY ssg_order"; }
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$ssg_package = $ssg_package .'["'.$data->ssg_path.'", "'.$data->ssg_link.'", "'.$data->ssg_target.'", "'.$data->ssg_title.'"],';
		}
		
		$ssg_package = substr($ssg_package,0,(strlen($ssg_package)-1));
		$newwrapperid = $ssg_type;
		$type = "auto";
		$ssg_pluginurl = get_option('siteurl') . "/wp-content/plugins/superb-slideshow-gallery/";
		
		$ssg_xml = $ssg_xml .'<script type="text/javascript">';
		$ssg_xml = $ssg_xml .'var mygallery=new SuperbSlideshowGallery({wrapperid: "'.$newwrapperid.'", dimensions: ['.$ssg_width.', '.$ssg_height.'], imagearray: [ '.$ssg_package.' ],displaymode: {type:"'.$type.'", pause:'.$ssg_pause.', cycles:'.$ssg_cycles.', wraparound:false},	persist: false, fadeduration: '.$ssg_fadeduration.', descreveal: "'.$ssg_descreveal.'",togglerid: ""})';
		$ssg_xml = $ssg_xml .'</script>';
		$ssg_xml = $ssg_xml .'<div id="'.$newwrapperid.'"></div>';
	}
	else
	{
		$ssg_xml = "No records found, please check your short code";
	}
	return $ssg_xml;
}

function ssg_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_ssg_TABLE . "'") != WP_ssg_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_ssg_TABLE . "` (";
		$sSql = $sSql . "`ssg_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`ssg_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssg_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssg_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_title` VARCHAR( 1024 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_order` INT NOT NULL ,";
		$sSql = $sSql . "`ssg_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ssg_date` INT NOT NULL ,";
		$sSql = $sSql . "PRIMARY KEY ( `ssg_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (`ssg_path`, `ssg_link`, `ssg_target` , `ssg_title` , `ssg_order` , `ssg_status` , `ssg_type` , `ssg_date`)"; 
		$sSql = $sSql . "VALUES ('".get_option('siteurl')."/wp-content/plugins/superb-slideshow-gallery/images/250x167_1.jpg','#','_parent','No title','1', 'YES', 'page', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (`ssg_path`, `ssg_link`, `ssg_target` , `ssg_title` , `ssg_order` , `ssg_status` , `ssg_type` , `ssg_date`)"; 
		$sSql = $sSql . "VALUES ('".get_option('siteurl')."/wp-content/plugins/superb-slideshow-gallery/images/250x167_2.jpg','#','_parent','No title','2', 'YES', 'page', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (`ssg_path`, `ssg_link`, `ssg_target` , `ssg_title` , `ssg_order` , `ssg_status` , `ssg_type` , `ssg_date`)"; 
		$sSql = $sSql . "VALUES ('".get_option('siteurl')."/wp-content/plugins/superb-slideshow-gallery/images/250x167_3.jpg','#','_parent','No title','3', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_ssg_TABLE . "` (`ssg_path`, `ssg_link`, `ssg_target` , `ssg_title` , `ssg_order` , `ssg_status` , `ssg_type` , `ssg_date`)"; 
		$sSql = $sSql . "VALUES ('".get_option('siteurl')."/wp-content/plugins/superb-slideshow-gallery/images/250x167_4.jpg','#','_parent','No title','4', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	add_option('ssg_title', "superb gallery");
	add_option('ssg_width', "250");
	add_option('ssg_height', "167");
	add_option('ssg_pause', "2500");
	add_option('ssg_fadeduration', "500");
	add_option('ssg_descreveal', "always");
	add_option('ssg_cycles', "0");
	add_option('ssg_random', "YES");
	add_option('ssg_type', "widget");
	add_option('ssg_descreveal1', "peek-a-boo");
}

function ssg_widget($args) 
{
	extract($args);
	if(get_option('ssg_title') <> "")
	{
		echo $before_widget . $before_title;
		echo get_option('ssg_title');
		echo $after_title;
	}
	ssg_show();
	if(get_option('ssg_title') <> "")
	{
		echo $after_widget;
	}
}

function ssg_admin_option() 
{
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo "Superb slideshow gallery";
	echo "</h2>";
	$ssg_title = get_option('ssg_title');
	$ssg_width = get_option('ssg_width');
	$ssg_height = get_option('ssg_height');
	$ssg_pause = get_option('ssg_pause');
	$ssg_fadeduration = get_option('ssg_fadeduration');
	$ssg_descreveal = get_option('ssg_descreveal');
	$ssg_descreveal1 = get_option('ssg_descreveal1');
	$ssg_cycles = get_option('ssg_cycles');
	$ssg_random = get_option('ssg_random');
	$ssg_type = get_option('ssg_type');
	if (@$_POST['ssg_submit']) 
	{
		$ssg_title = stripslashes($_POST['ssg_title']);
		$ssg_width = stripslashes($_POST['ssg_width']);
		$ssg_height = stripslashes($_POST['ssg_height']);
		
		$ssg_pause = stripslashes($_POST['ssg_pause']);
		$ssg_fadeduration = stripslashes($_POST['ssg_fadeduration']);
		$ssg_descreveal = stripslashes($_POST['ssg_descreveal']);
		$ssg_descreveal1 = stripslashes($_POST['ssg_descreveal1']);
		$ssg_cycles = stripslashes($_POST['ssg_cycles']);
		$ssg_random = stripslashes($_POST['ssg_random']);
		$ssg_type = stripslashes($_POST['ssg_type']);
		
		update_option('ssg_title', $ssg_title );
		update_option('ssg_width', $ssg_width );
		update_option('ssg_height', $ssg_height );
		
		update_option('ssg_pause', $ssg_pause );
		update_option('ssg_fadeduration', $ssg_fadeduration );
		update_option('ssg_descreveal', $ssg_descreveal );
		update_option('ssg_descreveal1', $ssg_descreveal1 );
		update_option('ssg_cycles', $ssg_cycles );
		update_option('ssg_random', $ssg_random );
		update_option('ssg_type', $ssg_type );
	}
	?><form name="form_woo" method="post" action="">
	<?php
	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $ssg_title . '" name="ssg_title" id="ssg_title" /> Widget title.</p>';
	
	echo '<p>Width:<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $ssg_width . '" name="ssg_width" id="ssg_width" /> Widget Width (only number).</p>';
	echo '<p>Height:<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $ssg_height . '" name="ssg_height" id="ssg_height" /> Widget Height (only number).</p>';
	
	echo '<p>Pause:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $ssg_pause . '" name="ssg_pause" id="ssg_pause" /> Only Number / Pause between content change (millisec).</p>';
	echo '<p>Transduration:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $ssg_fadeduration . '" name="ssg_fadeduration" id="ssg_fadeduration" /> Only Number / Duration of transition (affects only IE users).</p>';
	
	echo '<p>Description option (For widget) :<br><input  style="width: 100px;" type="text" value="';
	echo $ssg_descreveal . '" name="ssg_descreveal" id="ssg_descreveal" /> (ondemand/always/peek-a-boo)</p>';
	echo '<p>Description option (For post and pages) :<br><input  style="width: 100px;" type="text" value="';
	echo $ssg_descreveal1 . '" name="ssg_descreveal1" id="ssg_descreveal1" /> (ondemand/always/peek-a-boo)</p>';
	
	echo '<p>Cycles :<br><input  style="width: 100px;" type="text" value="';
	echo $ssg_cycles . '" name="ssg_cycles" id="ssg_cycles" /> (only number)</p>';
	
	
	echo '<p>Random :<br><input  style="width: 100px;" type="text" value="';
	echo $ssg_random . '" name="ssg_random" id="ssg_random" /> (YES/NO)</p>';
	echo '<p>Type:<br><input  style="width: 150px;" type="text" value="';
	echo $ssg_type . '" name="ssg_type" id="ssg_type" /> This field is to group the images.</p>';
	echo '<input name="ssg_submit" id="ssg_submit" class="button-primary" value="Submit" type="submit" />';
	?>
	</form>
	<table width="100%">
		<tr>
		  <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=superb-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
			<input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=superb-slideshow-gallery/superb-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
		  </td>
		</tr>
	  </table>
	<?php
	include_once("inc/help.php");
	echo "</div>";
}

function ssg_control()
{
	echo '<p>superb slideshow gallery.<br><br> To change the setting goto "superb slideshow gallery" link on setting menu. ';
	echo '<a href="options-general.php?page=superb-slideshow-gallery/superb-slideshow-gallery.php">click here</a></p>';
}

function ssg_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('superb slideshow gallery', 'superb slideshow gallery', 'ssg_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('superb slideshow gallery', array('superb slideshow gallery', 'widgets'), 'ssg_control');
	} 
}

function ssg_deactivation() 
{
}

function ssg_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Superb slideshow gallery','Superb slideshow gallery','manage_options',__FILE__,'ssg_admin_option');  
		add_options_page('Superb slideshow gallery', '', 'manage_options', "superb-slideshow-gallery/image-management.php",'' );
	}
}

function ssg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery.min', get_option('siteurl').'/wp-content/plugins/superb-slideshow-gallery/inc/jquery.min.js');
		wp_enqueue_script( 'superb-slideshow-gallery', get_option('siteurl').'/wp-content/plugins/superb-slideshow-gallery/inc/superb-slideshow-gallery.js');
	}
}    
 
add_action('wp_enqueue_scripts', 'ssg_add_javascript_files');
add_action('admin_menu', 'ssg_add_to_menu');
add_action("plugins_loaded", "ssg_widget_init");
register_activation_hook(__FILE__, 'ssg_install');
register_deactivation_hook(__FILE__, 'ssg_deactivation');
add_action('init', 'ssg_widget_init');
?>
