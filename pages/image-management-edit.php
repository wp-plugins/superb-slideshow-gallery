<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_ssg_TABLE."
	WHERE `ssg_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'ssg'); ?></strong></p></div><?php
}
else
{
	$ssg_errors = array();
	$ssg_success = '';
	$ssg_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_ssg_TABLE."`
		WHERE `ssg_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'ssg_path' => $data['ssg_path'],
		'ssg_link' => $data['ssg_link'],
		'ssg_target' => $data['ssg_target'],
		'ssg_title' => $data['ssg_title'],
		'ssg_order' => $data['ssg_order'],
		'ssg_status' => $data['ssg_status'],
		'ssg_type' => $data['ssg_type']
	);
}
// Form submitted, check the data
if (isset($_POST['ssg_form_submit']) && $_POST['ssg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('ssg_form_edit');
	
	$form['ssg_path'] = isset($_POST['ssg_path']) ? $_POST['ssg_path'] : '';
	if ($form['ssg_path'] == '')
	{
		$ssg_errors[] = __('Please enter the image path.', 'ssg');
		$ssg_error_found = TRUE;
	}

	$form['ssg_link'] = isset($_POST['ssg_link']) ? $_POST['ssg_link'] : '';
	if ($form['ssg_link'] == '')
	{
		$ssg_errors[] = __('Please enter the target link.', 'ssg');
		$ssg_error_found = TRUE;
	}
	
	$form['ssg_target'] = isset($_POST['ssg_target']) ? $_POST['ssg_target'] : '';
	$form['ssg_title'] = isset($_POST['ssg_title']) ? $_POST['ssg_title'] : '';
	$form['ssg_order'] = isset($_POST['ssg_order']) ? $_POST['ssg_order'] : '';
	$form['ssg_status'] = isset($_POST['ssg_status']) ? $_POST['ssg_status'] : '';
	$form['ssg_type'] = isset($_POST['ssg_type']) ? $_POST['ssg_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($ssg_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_ssg_TABLE."`
				SET `ssg_path` = %s,
				`ssg_link` = %s,
				`ssg_target` = %s,
				`ssg_title` = %s,
				`ssg_order` = %d,
				`ssg_status` = %s,
				`ssg_type` = %s
				WHERE ssg_id = %d
				LIMIT 1",
				array($form['ssg_path'], $form['ssg_link'], $form['ssg_target'], $form['ssg_title'], $form['ssg_order'], $form['ssg_status'], $form['ssg_type'], $did)
			);
		$wpdb->query($sSql);
		
		$ssg_success = __('Image details was successfully updated.', 'ssg');
	}
}

if ($ssg_error_found == TRUE && isset($ssg_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $ssg_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($ssg_error_found == FALSE && strlen($ssg_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $ssg_success; ?> 
		<a href="<?php echo WP_SSG_ADMIN_URL; ?>"><?php _e('Click here', 'ssg'); ?></a> <?php _e('to view the details', 'ssg'); ?></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo WP_SSG_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Superb slideshow gallery', 'ssg'); ?></h2>
	<form name="ssg_form" method="post" action="#" onsubmit="return ssg_submit()"  >
      <h3><?php _e('Update image details', 'ssg'); ?></h3>
      <label for="tag-image"><?php _e('Enter image path', 'ssg'); ?></label>
      <input name="ssg_path" type="text" id="ssg_path" value="<?php echo $form['ssg_path']; ?>" size="125" />
      <p><?php _e('Where is the picture located on the internet', 'ssg'); ?></p>
      <label for="tag-link"><?php _e('Enter target link', 'ssg'); ?></label>
      <input name="ssg_link" type="text" id="ssg_link" value="<?php echo $form['ssg_link']; ?>" size="125" />
      <p><?php _e('When someone clicks on the picture, where do you want to send them', 'ssg'); ?></p>
      <label for="tag-target"><?php _e('Select target option', 'ssg'); ?></label>
      <select name="ssg_target" id="ssg_target">
        <option value='_blank' <?php if($form['ssg_target']=='_blank') { echo 'selected' ; } ?>>_blank</option>
        <option value='_parent' <?php if($form['ssg_target']=='_parent') { echo 'selected' ; } ?>>_parent</option>
        <option value='_self' <?php if($form['ssg_target']=='_self') { echo 'selected' ; } ?>>_self</option>
        <option value='_new' <?php if($form['ssg_target']=='_new') { echo 'selected' ; } ?>>_new</option>
      </select>
      <p><?php _e('Do you want to open link in new window?', 'ssg'); ?></p>
      <label for="tag-title"><?php _e('Enter image reference', 'ssg'); ?></label>
      <input name="ssg_title" type="text" id="ssg_title" value="<?php echo $form['ssg_title']; ?>" size="125" />
      <p><?php _e('Enter image reference. This is only for reference.', 'ssg'); ?></p>
      <label for="tag-select-gallery-group"><?php _e('Select gallery type/group', 'ssg'); ?></label>
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
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["ssg_type"] = "GROUP" . $j;
		}
		$arrDistinctData[$j+1]["ssg_type"] = "WIDGET";
		$arrDistinctData[$j+2]["ssg_type"] = "SAMPLE";
		$selected = "";
		//$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		$arrDistinctDatas = $arrDistinctData;
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			if(strtoupper($form['ssg_type']) == strtoupper($arrDistinct["ssg_type"]) ) 
			{ 
				$selected = "selected"; 
			}
			?>
			<option value='<?php echo $arrDistinct["ssg_type"]; ?>' <?php echo $selected; ?>><?php echo strtoupper($arrDistinct["ssg_type"]); ?></option>
			<?php
			$selected = "";
		}
		?>
		</select>
      <p><?php _e('This is to group the images. Select your slideshow group.', 'ssg'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'ssg'); ?></label>
      <select name="ssg_status" id="ssg_status">
        <option value='YES' <?php if($form['ssg_status']=='YES') { echo 'selected' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['ssg_status']=='NO') { echo 'selected' ; } ?>>No</option>
      </select>
      <p><?php _e('Do you want the picture to show in your galler?', 'ssg'); ?></p>
      <label for="tag-display-order"><?php _e('Display order', 'ssg'); ?></label>
      <input name="ssg_order" type="text" id="ssg_order" size="10" value="<?php echo $form['ssg_order']; ?>" maxlength="3" />
      <p><?php _e('What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.', 'ssg'); ?></p>
      <input name="ssg_id" id="ssg_id" type="hidden" value="">
      <input type="hidden" name="ssg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="<?php _e('Submit', 'ssg'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="ssg_redirect()" value="<?php _e('Cancel', 'ssg'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="ssg_help()" value="<?php _e('Help', 'ssg'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('ssg_form_edit'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'ssg'); ?>
	<a target="_blank" href="<?php echo WP_SSG_FAV; ?>"><?php _e('click here', 'ssg'); ?></a>
</p>
</div>