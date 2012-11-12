<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=superb-slideshow-gallery/image-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['ssg_link']) <>"")
    {
			if($_POST['ssg_id'] == "" )
			{
					$sql = "insert into ".WP_ssg_TABLE.""
					. " set `ssg_path` = '" . mysql_real_escape_string(trim($_POST['ssg_path']))
					. "', `ssg_link` = '" . mysql_real_escape_string(trim($_POST['ssg_link']))
					. "', `ssg_target` = '" . mysql_real_escape_string(trim($_POST['ssg_target']))
					. "', `ssg_title` = '" . mysql_real_escape_string(trim($_POST['ssg_title']))
					. "', `ssg_order` = '" . mysql_real_escape_string(trim($_POST['ssg_order']))
					. "', `ssg_status` = '" . mysql_real_escape_string(trim($_POST['ssg_status']))
					. "', `ssg_type` = '" . mysql_real_escape_string(trim($_POST['ssg_type']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_ssg_TABLE.""
					. " set `ssg_path` = '" . mysql_real_escape_string(trim($_POST['ssg_path']))
					. "', `ssg_link` = '" . mysql_real_escape_string(trim($_POST['ssg_link']))
					. "', `ssg_target` = '" . mysql_real_escape_string(trim($_POST['ssg_target']))
					. "', `ssg_title` = '" . mysql_real_escape_string(trim($_POST['ssg_title']))
					. "', `ssg_order` = '" . mysql_real_escape_string(trim($_POST['ssg_order']))
					. "', `ssg_status` = '" . mysql_real_escape_string(trim($_POST['ssg_status']))
					. "', `ssg_type` = '" . mysql_real_escape_string(trim($_POST['ssg_type']))
					. "' where `ssg_id` = '" . $_POST['ssg_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_ssg_TABLE." where ssg_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_ssg_TABLE." where ssg_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $ssg_id_x = htmlspecialchars(stripslashes($data->ssg_id)); 
		if ( !empty($data) ) $ssg_path_x = htmlspecialchars(stripslashes($data->ssg_path)); 
        if ( !empty($data) ) $ssg_link_x = htmlspecialchars(stripslashes($data->ssg_link));
		if ( !empty($data) ) $ssg_target_x = htmlspecialchars(stripslashes($data->ssg_target));
        if ( !empty($data) ) $ssg_title_x = htmlspecialchars(stripslashes($data->ssg_title));
		if ( !empty($data) ) $ssg_order_x = htmlspecialchars(stripslashes($data->ssg_order));
		if ( !empty($data) ) $ssg_status_x = htmlspecialchars(stripslashes($data->ssg_status));
		if ( !empty($data) ) $ssg_type_x = htmlspecialchars(stripslashes($data->ssg_type));
        $submittext = "Update Message";
    }
    ?>
  <h2>Superb slideshow gallery</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/superb-slideshow-gallery/inc/setting.js"></script>
  <form name="ssg_form" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return ssg_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image url:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssg_path" type="text" id="ssg_path" value="<?php echo @$ssg_path_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssg_link" type="text" id="ssg_link" value="<?php echo @$ssg_link_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter target option:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssg_target" type="text" id="ssg_target" value="<?php echo @$ssg_target_x; ?>" size="50" /> ( _blank, _parent, _self, _new )</td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter image title:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssg_title" type="text" id="ssg_title" value="<?php echo @$ssg_title_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter gallery type (This is to group the images):</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssg_type" type="text" id="ssg_type" value="<?php echo @$ssg_type_x; ?>" size="50" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="ssg_status" id="ssg_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$ssg_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$ssg_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="78%" align="left" valign="middle"><input name="ssg_order" type="text" id="ssg_rder" size="10" value="<?php echo @$ssg_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="ssg_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=superb-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=superb-slideshow-gallery/superb-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
			  <input name="Help" lang="publish" class="button-primary" onclick="ssg_help()" value="Help" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="ssg_id" id="ssg_id" type="hidden" value="<?php echo @$ssg_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_ssg_TABLE." order by ssg_type,ssg_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_ssg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="10%" align="left" scope="col">Type
              </td>
            <th width="52%" align="left" scope="col">Title
              </td>
			 <th width="10%" align="left" scope="col">Target
              </td>
            <th width="8%" align="left" scope="col">Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->ssg_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssg_type)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssg_title)); ?></td>
			<td align="left" valign="middle"><?php echo(stripslashes($data->ssg_target)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssg_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssg_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=superb-slideshow-gallery/image-management.php&DID=<?php echo($data->ssg_id); ?>">Edit</a> &nbsp; <a onClick="javascript:ssg_delete('<?php echo($data->ssg_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right" height="30"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=superb-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=superb-slideshow-gallery/superb-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
		<input name="Help1" lang="publish" class="button-primary" onclick="ssg_help()" value="Help" type="button" />
      </td>
    </tr>
  </table>
</div>
Check official website for live demo and more information <a target="_blank" href='http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/'>click here</a><br> 