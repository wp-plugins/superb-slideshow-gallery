/**
 *     Superb slideshow gallery
 *     Copyright (C) 2011 - 2015 www.gopiplus.com
 *     http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
		document.frm_ssg_display.action="options-general.php?page=superb-slideshow-gallery&ac=del&did="+id;
		document.frm_ssg_display.submit();
	}
}	

function ssg_redirect()
{
	window.location = "options-general.php?page=superb-slideshow-gallery";
}

function ssg_help()
{
	window.open("http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/");
}