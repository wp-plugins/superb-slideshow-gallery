/*
##################################################################################################################################
###### Project   : superb slideshow gallery  																				######
###### File Name : setting.js                   																			######
###### Purpose   : This javascript is to authenticate the form.  															######
###### Created   : 10-10-10                  																				######
###### Modified  : 10-10-10                  																				######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        											######
###### Link      : http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/      									######
##################################################################################################################################
*/


function ssg_submit()
{
	if(document.ssg_form.ssg_path.value=="")
	{
		alert("Please enter the image path.")
		document.ssg_form.ssg_path.focus();
		return false;
	}
	else if(document.ssg_form.ssg_link.value=="")
	{
		alert("Please enter the target link.")
		document.ssg_form.ssg_link.focus();
		return false;
	}
	else if(document.ssg_form.ssg_target.value=="")
	{
		alert("Please enter the target status.")
		document.ssg_form.ssg_target.focus();
		return false;
	}
	//else if(document.ssg_form.ssg_title.value=="")
//	{
//		alert("Please enter the image title.")
//		document.ssg_form.ssg_title.focus();
//		return false;
//	}
	else if(document.ssg_form.ssg_type.value=="")
	{
		alert("Please enter the gallery type.")
		document.ssg_form.ssg_type.focus();
		return false;
	}
	else if(document.ssg_form.ssg_status.value=="")
	{
		alert("Please select the display status.")
		document.ssg_form.ssg_status.focus();
		return false;
	}
	else if(document.ssg_form.ssg_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.ssg_form.ssg_order.focus();
		return false;
	}
	else if(isNaN(document.ssg_form.ssg_order.value))
	{
		alert("Please enter the display order, only number.")
		document.ssg_form.ssg_order.focus();
		return false;
	}
}

function ssg_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_ssg_display.action="options-general.php?page=superb-slideshow-gallery/image-management.php&AC=DEL&DID="+id;
		document.frm_ssg_display.submit();
	}
}	

function ssg_redirect()
{
	window.location = "options-general.php?page=superb-slideshow-gallery/image-management.php";
}
