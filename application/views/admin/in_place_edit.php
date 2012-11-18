
<script>
$(document).ready(function(){
	$('td.edit').click(function(){
        $('.ajax').html($('.ajax input').val());
        $('.ajax').removeClass('ajax');
		$(this).addClass('ajax');
		$(this).html('<input id="editbox" size="'+$(this).text().length+'" type="text" value="' + $(this).text() + '">');
		$('#editbox').focus();
    }
	);

	$('td.edit').keydown(function(event){
		 arr = $(this).attr('class').split( " " );
		 if(event.which == 13)
		 {
	  		$.ajax({
		  		type: "POST",
			    url:"inlinesave.php",
				data: "value="+$('.ajax input').val()+"&rownum="+arr[2]+"&field="+arr[1],
				success: function(data){
					 $('.ajax').html($('.ajax input').val());
				     $('.ajax').removeClass('ajax');
				}});
		}
	});

	$('#editbox').live('blur',function(){
	   $('.ajax').html($('.ajax input').val());
	   $('.ajax').removeClass('ajax');
	});
});
</script>

<h5>This feature is currently busted.  Still looking for a decent inline js library...</h5>
<div class="navbar">
<div class="navbar-inner">
  <a class="brand" href="#">In-Place Editing</a>
</div>
</div>

<table class="table table-striped">
<tr>
<th>Email</th>
<th>Name</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Zip Code</th>
<th>Action</th>
</tr>


<?php

	$dwarnstr = 'onclick="return confirm(' . "'" . "Are you sure?  This will delete registered user record.  THERE IS NO RECOVERY!" . "');".'"';

	foreach ($records as $row) {

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
			<td class=edit email_address $row->id>".$row->email_address."</td>
			<td>".$row->l_name.", ".$row->f_name."</td>
			<td>".$row->address_1." ".$row->address_2."</td>
			<td>".$row->city."</td>
			<td>".$row->state."</td>
			<td>".$row->zip."</td>";

		echo "
				<td>".anchor('admin/registered_users/quick_entry/'.$row->id,'Edit','')." | "
					.anchor('admin/registered_users/delete/'.$row->id,'Delete',$dwarnstr)."</td>
			</tr>";
	}
?>
</table>

