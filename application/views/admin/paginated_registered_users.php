<div class="navbar">
<div class="navbar-inner">
  <a class="brand" href="#">Paginated Registered Users</a>
  <form action="/admin/registered_users/create" method="post" class="navbar-form form-inline pull-left">
	<button type="submit" class="btn">Create User</button>
  </form>

  <form action="/admin/registered_users/plist" method="post"class="navbar-form form-inline pull-right">
	<button type="submit" class="btn">Extras</button>
	<label class="radio">
	  <input type="radio" name="extra_col" value="on"
	  <?php if ($this->session->userdata('extra_col') == 'on') {echo " checked";}?>
	  > On
	</label>
	<label class="radio">
	  <input type="radio" name="extra_col" value="off"
	  <?php if ($this->session->userdata('extra_col') == 'off') {echo " checked";}?>
	  > Off
	</label>
  </form>
</div>
</div>

<table class="table table-striped">
<tr>
<?php
if ($this->session->userdata('extra_col') == 'on')
{
	echo "<th>ID</th>";
	echo "<th>Date Modified</th>";
	echo "<th>IP Address</th>";
}
?>

<th>Email</th>
<th>Name</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Zip Code</th>
<?php

//echo $this->session->all_userdata();//die();


?>
<th>Action</th>
</tr>

<?php

	$dwarnstr = 'onclick="return confirm(' . "'" . "Are you sure?  This will delete registered user record.  THERE IS NO RECOVERY!" . "');".'"';

	foreach ($users as $row) {

//		echo "<br>".anchor($dstr,'Delete Product &amp; Images',$dwarnstr);

		echo "<tr>";

		if ($this->session->userdata('extra_col') == 'on')
		{
			echo "
			<td>".$row->id."</td>
			<td>".date("y/n/j h:ia",strtotime($row->date_modified))."</td>
			<td>".$row->ip_address."</td>";
		}

		echo "
			<td>".$row->email_address."</td>
			<td>".$row->l_name.", ".$row->f_name."</td>
			<td>".$row->address_1." ".$row->address_2."</td>
			<td>".$row->city."</td>
			<td>".$row->state."</td>
			<td>".$row->zip."</td>";

		echo "
				<td>".anchor('admin/registered_users/quick_entry/'.$row->id,'Edit','')." | "
					.anchor('admin/registered_users/delete_user/'.$row->id,'Delete',$dwarnstr)."</td>
			</tr>";
	}
?>
</table>

<?php
/*
 * the pagination config for CI has the bootstrap pagination markup
 */
	echo $this->pagination->create_links();
?>
