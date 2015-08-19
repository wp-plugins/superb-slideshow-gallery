<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_ssg_display']) && $_POST['frm_ssg_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$ssg_success = '';
	$ssg_success_msg = FALSE;
	
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
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('ssg_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_ssg_TABLE."`
					WHERE `ssg_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$ssg_success_msg = TRUE;
			$ssg_success = __('Selected record was successfully deleted.', 'ssg');
		}
	}
	
	if ($ssg_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $ssg_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Superb slideshow gallery', 'ssg'); ?><a class="add-new-h2" href="<?php echo WP_SSG_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'ssg'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_ssg_TABLE."` order by ssg_type, ssg_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_SSG_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_ssg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="row" style="padding: 8px 2px;"><input type="checkbox" name="ssg_group_item[]" /></th>
			<th scope="col"><?php _e('Type/Group', 'ssg'); ?></th>
			<th scope="col"><?php _e('Reference', 'ssg'); ?></th>
            <th scope="col"><?php _e('URL', 'ssg'); ?></th>
            <th scope="col"><?php _e('Order', 'ssg'); ?></th>
            <th scope="col"><?php _e('Display', 'ssg'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="row" style="padding: 8px 2px;"><input type="checkbox" name="ssg_group_item[]" /></th>
			<th scope="col"><?php _e('Type/Group', 'ssg'); ?></th>
			<th scope="col"><?php _e('Reference', 'ssg'); ?></th>
            <th scope="col"><?php _e('URL', 'ssg'); ?></th>
            <th scope="col"><?php _e('Order', 'ssg'); ?></th>
            <th scope="col"><?php _e('Display', 'ssg'); ?></th>
          </tr>
        </tfoot>
		<tbody>
		<?php 
		$i = 0;
		if(count($myData) > 0 )
		{
			foreach ($myData as $data)
			{
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input type="checkbox" value="<?php echo $data['ssg_id']; ?>" name="ssg_group_item[]"></td>
					<td>
					<strong><?php echo esc_html(stripslashes($data['ssg_type'])); ?></strong>
					<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_SSG_ADMIN_URL; ?>&ac=edit&amp;did=<?php echo $data['ssg_id']; ?>"><?php _e('Edit', 'ssg'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:ssg_delete('<?php echo $data['ssg_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'ssg'); ?></a></span> 
					</div>
					</td>
					<td><?php echo esc_html(stripslashes($data['ssg_title'])); ?></td>
					<td><a href="<?php echo esc_html(stripslashes($data['ssg_path'])); ?>" target="_blank"><?php echo esc_html(stripslashes($data['ssg_path'])); ?></a></td>
					<td><?php echo esc_html(stripslashes($data['ssg_order'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['ssg_status'])); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
			} 
		}
		else
		{
			?><tr><td colspan="6" align="center"><?php _e('No records available', 'ssg'); ?></td></tr><?php 
		}
		?>
		</tbody>
        </table>
		<?php wp_nonce_field('ssg_form_show'); ?>
		<input type="hidden" name="frm_ssg_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_SSG_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'ssg'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_SSG_ADMIN_URL; ?>&amp;ac=set"><?php _e('Widget setting', 'ssg'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_SSG_FAV; ?>"><?php _e('Help', 'ssg'); ?></a>
	  </h2>
	  </div>
	  <br />
	  <p class="description">
		<?php _e('Check official website for more information', 'ssg'); ?>
		<a target="_blank" href="<?php echo WP_SSG_FAV; ?>"><?php _e('click here', 'ssg'); ?></a>
	  </p>
	</div>
</div>