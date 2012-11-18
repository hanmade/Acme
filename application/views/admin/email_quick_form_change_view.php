<div id=fm-container style='float: left'>

<fieldset>
<legend>Quick Email Add</legend>

<?php

/*
 * if the form is called with a trailing integer (the record id)
 * then we look up the record and fill in the form fields.
 * if not, we null the form fields
 * we also set the $method as a hidden field so the form handler can
 * do the right thing
 */

	if (!isset($form_method))
	{
		exit('oops. no form_method for quick entry form.');
	}


	if ($form_method == 'change')
	{
		echo form_open("admin/email_addresses/quick_entry/".$row->id);
//		echo "<input type='hidden' name='id' value='.$row->id.' />";
		$form_email_address = $row->email_address;
		$form_f_name = $row->f_name;
		$form_l_name = $row->l_name;
		$form_zip = $row->zip;
		$form_gender_1 = $row->gender_1;
		$form_gender_2 = $row->gender_2;
		$form_gender_3 = $row->gender_3;
		$form_style_1 = $row->style_1;
		$form_style_2 = $row->style_2;
		$form_style_3 = $row->style_3;
		$form_style_4 = $row->style_4;
		$form_season_1 = $row->season_1;
		$form_season_2 = $row->season_2;
		$form_season_3 = $row->season_3;
		$form_season_4 = $row->season_4;
		$form_brand_1 = $row->brand_1;
		$form_brand_2 = $row->brand_2;
		$form_brand_3 = $row->brand_3;
	}
	elseif ($form_method == 'add')
	{
		echo form_open("admin/email_addresses/quick_entry/add");
		$form_email_address = set_value('email_address');
		$form_f_name = set_value('f_name');
		$form_l_name = set_value('l_name');
		$form_zip = set_value('zip');
		$form_gender_1 = set_value('gender_1');
		$form_gender_2 = set_value('gender_2');
		$form_gender_3 = set_value('gender_3');
		$form_style_1 = set_value('style_1');
		$form_style_2 = set_value('style_2');
		$form_style_3 = set_value('style_3');
		$form_style_4 = set_value('style_4');
		$form_season_1 = set_value('season_1');
		$form_season_2 = set_value('season_2');
		$form_season_3 = set_value('season_3');
		$form_season_4 = set_value('season_4');
		$form_brand_1 = set_value('brand_1');
		$form_brand_2 = set_value('brand_2');
		$form_brand_3 = set_value('brand_3');
	}
	else
	{
		exit('oops. bad form_method value');
	}

?>

<?php echo form_error('email_address'); ?>
<label>Email Address</label>
<div>
<?php
//since we can't have duplicates we can't allow changing the email address
//if we are just changing the record
if ($form_method == 'change')
{
	echo "<input name='email_address' value='$form_email_address' size='25' />";
}
else
{
	echo "<input name='email_address' value='$form_email_address' size='25' />";
}
?>
</div>

<?php echo form_error('f_name'); ?>
<label>First Name</label>
<div>
	<input name='f_name' value='<?php echo $form_f_name; ?>' size='15' />
</div>

<?php echo form_error('l_name'); ?>
<label>Last Name</label>
<div>
	<input name='l_name' value='<?php echo $form_l_name; ?>' size='15' />
</div>

<?php echo form_error('zip'); ?>
<label>Zip Code</label>
<div>
	<input name='zip' value='<?php echo $form_zip; ?>' size='15' />
</div>

<label>Preferred Genders</label>
<div>
<?php
echo form_checkbox('gender_1', 'Womens', $form_gender_1 == 'Womens' ? TRUE : FALSE ).' Womens&nbsp;&nbsp';
echo form_checkbox('gender_2', 'Mens', $form_gender_2 == 'Mens' ? TRUE : FALSE). ' Mens&nbsp;&nbsp';
echo form_checkbox('gender_3', 'Kids', $form_gender_3 == 'Kids' ? TRUE : FALSE). ' Kids&nbsp;&nbsp';
?>
</div>

<label>Preferred Styles</label>
<div>
<?php
echo form_checkbox('style_1', 'Stylish', $form_style_1 == 'Stylish' ? TRUE : FALSE ).' Stylish&nbsp;&nbsp';
echo form_checkbox('style_2', 'Outdoors', $form_style_2 == 'Outdoors' ? TRUE : FALSE ).' Outdoors&nbsp;&nbsp';
echo form_checkbox('style_3', 'Casual', $form_style_3 == 'Casual' ? TRUE : FALSE ).' Casual&nbsp;&nbsp';
echo form_checkbox('style_4', 'Athletic', $form_style_4 == 'Athletic' ? TRUE : FALSE ).' Athletic&nbsp;&nbsp';
?>
</div>

<label>Preferred Seasons</label>
<div>
<?php
echo form_checkbox('season_1', 'Spring', $form_season_1 == 'Spring' ? TRUE : FALSE ).' Spring&nbsp;&nbsp';
echo form_checkbox('season_2', 'Summer', $form_season_2 == 'Summer' ? TRUE : FALSE ).' Summer&nbsp;&nbsp';
echo form_checkbox('season_3', 'Back-to-School', $form_season_3 == 'Back-to-School' ? TRUE : FALSE ).' Back-to-School&nbsp;&nbsp';
echo form_checkbox('season_4', 'Winter', $form_season_4 == 'Winter' ? TRUE : FALSE ).' Winter&nbsp;&nbsp';
?>
</div>

<label>Preferred Brands</label>
<div>
<?php
echo form_dropdown('brand_1', $brand_options, $form_brand_1).'&nbsp;&nbsp';
echo form_dropdown('brand_2', $brand_options, $form_brand_2).'&nbsp;&nbsp';
echo form_dropdown('brand_3', $brand_options, $form_brand_3).'&nbsp;&nbsp';
?>
</div>

<?php
	if ($form_method == "change")
	{
		$form_submit_val = "Change";
	}
	else
	{
		$form_submit_val = "Save";
	}
?>

<div id='fm-submit'>
	<input type=submit value="<?php echo $form_submit_val; ?>" />
</div>

</form>
</fieldset>
</div>
