<?php
// Form submitted, check the data
if (isset($_POST['frm_ssg_display']) && $_POST['frm_ssg_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
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
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
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
			$ssg_success = __('Selected record was successfully deleted.', WP_ssg_UNIQUE_NAME);
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
    <h2><?php echo WP_ssg_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=superb-slideshow-gallery&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_ssg_TABLE."` order by ssg_type, ssg_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/superb-slideshow-gallery/pages/setting.js"></script>
		<form name="frm_ssg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="row" scope="col"><input type="checkbox" name="ssg_group_item[]" /></td>
			<th scope="col">Type</td>
			<th scope="col">Reference</td>
            <th scope="col">URL</td>
			<th scope="col">Target</td>
            <th scope="col">Order</td>
            <th scope="col">Display</td>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="row" scope="col"><input type="checkbox" name="ssg_group_item[]" /></td>
			<th scope="col">Type</td>
			<th scope="col">Reference</td>
            <th scope="col">URL</td>
			<th scope="col">Target</td>
            <th scope="col">Order</td>
            <th scope="col">Display</td>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			$displayisthere = FALSE;
			foreach ($myData as $data)
			{
				if($data['ssg_status'] == 'YES') 
				{
					$displayisthere = TRUE; 
				}
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input type="checkbox" value="<?php echo $data['ssg_id']; ?>" name="ssg_group_item[]"></th>
					<td>
					<strong><?php echo esc_html(stripslashes($data['ssg_type'])); ?></strong>
					<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=superb-slideshow-gallery&amp;ac=edit&amp;did=<?php echo $data['ssg_id']; ?>">Edit</a> | </span>
						<span class="trash"><a onClick="javascript:ssg_delete('<?php echo $data['ssg_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
					</div>
					</td>
					<td><?php echo esc_html(stripslashes($data['ssg_title'])); ?></td>
					<td><a href="<?php echo esc_html(stripslashes($data['ssg_path'])); ?>" target="_blank"><?php echo esc_html(stripslashes($data['ssg_path'])); ?></a></td>
					<td><?php echo esc_html(stripslashes($data['ssg_target'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['ssg_order'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['ssg_status'])); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
				} 
			?>
			<?php 
			if ($displayisthere == FALSE) 
			{ 
				?><tr><td colspan="6" align="center">No records available.</td></tr><?php 
			} 
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('ssg_form_show'); ?>
		<input type="hidden" name="frm_ssg_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=superb-slideshow-gallery&amp;ac=add">Add New</a>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=superb-slideshow-gallery&amp;ac=set">Widget setting</a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_ssg_FAV; ?>">Help</a>
	  </h2>
	  </div>
	  <br />
	<h3>Plugin configuration option</h3>
	<ol>
		<li>Drag and drop the widget.</li>
		<li>Add the plugin in the posts or pages using short code.</li>
		<li>Add directly in to the theme using PHP code.</li>
	</ol>
	  <p class="description"><?php echo WP_ssg_LINK; ?></p>
	</div>
</div>