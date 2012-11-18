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

<div class="btn-toolbar" style="margin-top: 10px;">
	<button class="btn btn-primary" type="button">Acme Administration Tools</button>
	<div class="btn-group">
	<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	Change Site Content
	<span class="caret"></span>
	</a>
	<ul class="dropdown-menu">
	<?php
	echo "
	<li>".anchor('admin/weekend_special/ilist', 'Weekend Special Page', '')."</li>
	<li>".anchor('admin/content_admin/about', 'About Page', '')."</li>
	<li>".anchor('admin/content_admin/hours', 'Store Hours', '')."</li>
	";
	?>
	</ul>
	</div><!-- btn group -->

	<div class="btn-group">
	<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	Registered Users
	<span class="caret"></span>
	</a>
	<ul class="dropdown-menu">
	<?php
	echo "
	<li>".anchor('admin/registered_users/ulist', 'List Sortable Users', '')."</li>
	<li>".anchor('admin/registered_users/plist', 'List Paginated Users', '')."</li>
	<li>".anchor('admin/registered_users/in_place_edit', 'In-Place Edit Example', '')."</li>
	<li>".anchor('admin/registered_users/make', 'Make New User Table', '')."</li>
	<li>".anchor('admin/registered_users/export_cvs', 'Export to CSV File (beta)', '')."</li>
	";
	?>
	</ul>
	</div><!-- btn group -->

	<div class="btn-group">
	<?php
	echo anchor('admin/gallery_images/ilist', 'Gallery', 'class=btn');
	?>
	</div><!-- btn group -->

	<div class="btn-group">
	<a class="btn" href="/">
	Back to Main Site
	</a>
	</div><!-- btn group -->

</div><!--  btn toolbar -->




