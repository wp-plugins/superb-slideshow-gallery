<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Superb slideshow gallery', 'superb-slideshow-gallery'); ?></h2>
	<h3><?php _e('Widget setting', 'superb-slideshow-gallery'); ?></h3>
    <?php
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
	
	if (isset($_POST['ssg_submit'])) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('ssg_form_setting');
			
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
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'superb-slideshow-gallery'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_SSG_PLUGIN_URL; ?>/pages/setting.js"></script>
    <form name="ssg_form" method="post" action="">
      
	  <label for="tag-title"><?php _e('Enter widget title', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_title" id="ssg_title" type="text" value="<?php echo $ssg_title; ?>" size="80" />
      <p><?php _e('Enter widget title, Only for widget.', 'superb-slideshow-gallery'); ?></p>
      
	  <label for="tag-width"><?php _e('Width (Only number)', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_width" id="ssg_width" type="text" value="<?php echo $ssg_width; ?>" />
      <p><?php _e('Widget Width (only number). (Example: 250)', 'superb-slideshow-gallery'); ?></p>
      
	  <label for="tag-height"><?php _e('Height of each image', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_height" id="ssg_height" type="text" value="<?php echo $ssg_height; ?>" />
      <p><?php _e('Widget Height (only number). (Example: 200)', 'superb-slideshow-gallery'); ?></p>
	  
	  <label for="tag-height"><?php _e('Pause', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_pause" id="ssg_pause" type="text" value="<?php echo $ssg_pause; ?>" />
      <p><?php _e('Only Number / Pause time of the slideshow in milliseconds.', 'superb-slideshow-gallery'); ?></p>
	  
	  <label for="tag-height"><?php _e('Transduration', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_fadeduration" id="ssg_fadeduration" type="text" value="<?php echo $ssg_fadeduration; ?>" />
      <p><?php _e('Only Number / Duration of transition (affects only IE users)', 'superb-slideshow-gallery'); ?></p>
	  
	  <label for="tag-height"><?php _e('Description option (For widget)', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_descreveal" id="ssg_descreveal" type="text" value="<?php echo $ssg_descreveal; ?>" />
      <p><?php _e('Enter : ondemand  (or) always  (or)  peek-a-boo', 'superb-slideshow-gallery'); ?></p>
	  
	  <label for="tag-height"><?php _e('Description option (For post and pages)', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_descreveal1" id="ssg_descreveal1" type="text" value="<?php echo $ssg_descreveal1; ?>" />
      <p><?php _e('Enter : ondemand  (or) always  (or)  peek-a-boo', 'superb-slideshow-gallery'); ?></p>
	  
	   <label for="tag-height"><?php _e('Cycles', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_cycles" id="ssg_cycles" type="text" value="<?php echo $ssg_cycles; ?>" />
      <p><?php _e('How many times do you want the gallery to cycle thru the pictures.', 'superb-slideshow-gallery'); ?></p>
	  
	  <label for="tag-height"><?php _e('Random', 'superb-slideshow-gallery'); ?></label>
      <input name="ssg_random" id="ssg_random" type="text" value="<?php echo $ssg_random; ?>" />
      <p><?php _e('Enter : YES (or) NO', 'superb-slideshow-gallery'); ?></p>
      
	  <label for="tag-height"><?php _e('Select your gallery group (Type)', 'superb-slideshow-gallery'); ?></label>
	  <select name="ssg_type" id="ssg_type">
	 	<?php
		$sSql = "SELECT distinct(ssg_type) as ssg_type FROM `".WP_ssg_TABLE."` order by ssg_type, ssg_order";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$selected = "";
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["ssg_type"] = strtoupper($DistinctData['ssg_type']);
			$i = $i+1;
		}
		foreach ($arrDistinctData as $arrDistinct)
		{
			if(strtoupper($ssg_type) == strtoupper($arrDistinct["ssg_type"]) ) 
			{ 
				$selected = "selected='selected'"; 
			}
			?>
			<option value='<?php echo $arrDistinct["ssg_type"]; ?>' <?php echo $selected; ?>><?php echo strtoupper($arrDistinct["ssg_type"]); ?></option>
			<?php
			$selected = "";
		}
		?>
      </select>
      <p><?php _e('This field is to group the images. Select your group name to fetch the images for widget.', 'superb-slideshow-gallery'); ?></p>
      <br />
	  <input name="ssg_submit" id="ssg_submit" class="button-primary" value="<?php _e('Submit', 'superb-slideshow-gallery'); ?>" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="ssg_redirect()" value="<?php _e('Cancel', 'superb-slideshow-gallery'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="ssg_help()" value="<?php _e('Help', 'superb-slideshow-gallery'); ?>" type="button" />
	  <?php wp_nonce_field('ssg_form_setting'); ?>
    </form>
  </div>
  <br />
<p class="description">
	<?php _e('Check official website for more information', 'superb-slideshow-gallery'); ?>
	<a target="_blank" href="<?php echo WP_SSG_FAV; ?>"><?php _e('click here', 'superb-slideshow-gallery'); ?></a>
</p>
</div>
