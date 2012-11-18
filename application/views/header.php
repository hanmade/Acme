<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" media="screen" href="/media/bootstrap/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" media="screen" href="/media/bootstrap/css/bootstrap-responsive.min.css" >
<link rel="stylesheet" type="text/css" media="screen" href="/media/css/acme.css" >
<script src="/media/js/jquery-1.8.1.min.js"></script>
<script src="/media/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div class="login">
<?php
if ($this->ion_auth->logged_in())
{
	$user = $this->ion_auth->get_user();
	echo anchor('/logout', 'logout as '.'['.$this->ion_auth->get_user()->username.']', '').'&nbsp;&nbsp;';
	if ($this->ion_auth->is_admin())
	{
		echo anchor('/admin/main', 'admin menu', '');
	}
}
?>
</div><!-- login -->
