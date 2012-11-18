<?php

/*
 * this controller is for mucking with collected email addresses
 */

class Inlinesave extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('/');
		}

	}

	function save() {
		//gather the fieldname and id
		echo $_POST;die();

	}


}
?>
