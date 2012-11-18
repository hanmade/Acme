<?php

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->is_admin() )
		{
			redirect('/');
		}
	}

	function index()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/admin_footer');
	}

}

