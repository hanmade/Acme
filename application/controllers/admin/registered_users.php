<?php

/*
 * this controller is for mucking with collected email addresses
 */

class Registered_users extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('/');
		}

	}

	function index() {

	}

/*
 * in-place edit example.  grab 10 records from the registered users db
 * and hammer away!
 */
	function in_place_edit()
	{
		$data['records'] = $this->Acme_model->get_10_users();

		$this->load->view('admin/admin_header');
		$this->load->view('admin/in_place_edit', $data);
		$this->load->view('admin/admin_footer');
	}
/*
 * model that will build a registered user table from a +/- 1700 row list
 */
	function make()
	{
		$this->Acme_model->make_users();
	}

	function delete_user()
	{
//check for segment with record id.
		if ($this->uri->segment(4))
		{
			if (!$this->Acme_model->delete_user($this->uri->segment(4)))
			{
				exit('oops. could not delete user');
			}
		}
		else
		{
			exit('oops. could not delete user: missing uri segment');
		}

		redirect('admin/registered_users/plist');

	}

	function plist()
	{
//		$this->output->enable_profiler(TRUE);
		$page = 0; //default page

		if ($this->input->post('extra_col'))
		{
			$foo = array('extra_col' => $this->input->post('extra_col'));
			$this->session->set_userdata($foo);
		}
		elseif (!$this->session->userdata('extra_col'))
		{
			$foo = array('extra_col' => 'off');
			$this->session->set_userdata($foo);
		}

		if ($this->uri->segment(4))
		{
			$page = $this->uri->segment(4);
		}

		$this->load->library('pagination');
//		echo $_SERVER['SERVER_NAME'];die();
		$config['base_url'] = 'http://'.$_SERVER['SERVER_NAME'].'/admin/registered_users/plist';
		$config['total_rows'] = $this->db->get('registered_users')->num_rows();
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['use_page_numbers'] = FALSE;
		$config['display_pages'] = TRUE;

		$config['first_link'] = '<i class="icon-fast-backward"></i>';
		$config['last_link'] = '<i class="icon-fast-forward"></i>';

		$config['prev_link'] = '<i class="icon-chevron-left"></i>';
		$config['next_link'] = '<i class="icon-chevron-right"></i>';

		$config['full_tag_open'] = "<div class='pagination'><ul>";
		$config['full_tag_close'] = '</ul></div>';

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li><a href=#><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';

		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$limit = $config['per_page'];

		if (!$data['users'] = $this->Acme_model->get_paginiated_users($limit, $page))
		{
			exit('no users in the db');
		}

//		$data['page'] = $page;

		$this->load->view('admin/admin_header');
		$this->load->view('admin/paginated_registered_users', $data);
		$this->load->view('admin/admin_footer');

	}

	function ulist() {

		$this->output->enable_profiler(TRUE);

/*
 * query the db for users sorted by the correct field
 * hand off to the view
 */

/*
 * see of the hidden column boxes have been checked
 * the mod_time and ip_address columns are optional.
 * if they are checked and the submit pressed, they are
 * parsed here.
 * if there's a post, we'll use that to set the sesssion
 * var the view uses, either 'on' or 'off'
 * if there is no session var, we'll set it to 'off'
 */
		if ($this->input->post('extra_col'))
		{
			$foo = array('extra_col' => $this->input->post('extra_col'));
			$this->session->set_userdata($foo);
		}
		elseif (!$this->session->userdata('extra_col'))
		{
			$foo = array('extra_col' => 'off');
			$this->session->set_userdata($foo);
		}

/*
 *  scrape the sort, order and page segments
 */
		$sort = 1;  //default = id
		$order = 1; //default = ASC

		if ($this->uri->segment(4))
		{
			$sort = $this->uri->segment(4);
		}

		if ($this->uri->segment(5))
		{
			$order = $this->uri->segment(5);
		}


		$foo = array('sort' => $sort);
		$this->session->set_userdata($foo);
		$foo = array('order' => $order);
		$this->session->set_userdata($foo);

/*
 * here we obvuscate the SQL from the URL segments
 */
		switch ($sort)
		{
			case 1;
				$qsort = 'id';
				break;
			case 2:
				$qsort = 'email_address';
				break;
			case 3:
				$qsort = 'l_name';
				break;
			case 4:
				$qsort = 'city';
				break;
			case 5:
				$qsort = 'state';
				break;
			case 6:
				$qsort = 'zip';
				break;
			case 7:
				$qsort = 'date_modified';
				break;
			case 8:
				$qsort = 'ip_address';
				break;
		}

		if ($order == 1) {
			$qorder = 'ASC';
		} elseif ($order == 2) {
			$qorder = 'DESC';
		}

		$data['record_count'] = $this->db->get('registered_users')->num_rows();
		if (!$data['users'] = $this->Acme_model->get_users($qsort, $qorder)){
			exit('no users in the db');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->view('admin/admin_header');
		$this->load->view('admin/registered_users', $data);
		$this->load->view('admin/admin_footer');
	}

	function update()
	{
		if (!$this->uri->segment(4) )
		{
			exit('oops. missing edit segment.');
		}

		$this->form_validation->set_error_delimiters('<span class="error">', '<br /></span>');
		$this->form_validation->set_rules('visitor_name', 'Visitor Name', 'trim|required|prep_for_form|min_length[6]|max_length[250]|xss_clean');
		$this->form_validation->set_rules('visitor_email', 'visitor_email', 'trim|required|valid_email|xss_clean]');
		$this->form_validation->set_message('valid_email', 'A valid email address is required');

		if ($this->form_validation->run() == FALSE)
		{
//			exit('got here');
			$data['row'] = $this->Cafe_model->get_email_addresses_row($this->uri->segment(4));
			$this->load->view('admin/admin_header');
			$this->load->view('admin/email_edit_form_view', $data);
			$this->load->view('admin/admin_footer');
		}
		else
		{
//			exit('valid form');
			$data = array(
				'visitor_name' => $this->input->post('visitor_name'),
				'visitor_email' => $this->input->post('visitor_email')
			);
//seg 4 is the id
			if (!$this->Cafe_model->update_email_address($data, $this->uri->segment(4)) )
			{
				exit('oops. update failed.');
			}

			redirect('admin/email_addresses/elist');

		}
	}

	function create()
	{

		$this->form_validation->set_error_delimiters('<span class="error">', '<br /></span>');
		$this->form_validation->set_rules('visitor_name', 'Visitor Name', 'trim|required|prep_for_form|min_length[6]|max_length[250]|xss_clean');
		$this->form_validation->set_rules('visitor_email', 'Email Address', 'trim|required|valid_email|is_unique[email_addresses.visitor_email]|xss_clean]');
		$this->form_validation->set_message('valid_email', 'A valid email address is required.');
		$this->form_validation->set_message('is_unique', 'This email address already exists.');
		$this->form_validation->set_message('required', '"%s" is a required field.');

		if ($this->form_validation->run() == FALSE)
		{
			//			exit('got here');
			$this->load->view('admin/admin_header');
			$this->load->view('admin/email_create_form_view');
			$this->load->view('admin/admin_footer');
		}
		else
		{
			//			exit('valid form');
			$data = array(
					'visitor_name'   => $this->input->post('visitor_name'),
					'visitor_email'  => $this->input->post('visitor_email'),
					'time_submitted' => time(),
        			'ip_address'	 => $_SERVER['REMOTE_ADDR']
			);
			//seg 4 is the id
			if (!$this->Cafe_model->insert_email_address($data))
			{
				exit('oops. update failed.');
			}

			redirect('admin/email_addresses/elist');

		}
	}

	function process_newlines($str)
	{
		$order   = array("\r\n\n", "\n\r", "\r\n", "\n\n", "\r\r", "\n", "\r");
		$replace = "<br />";
		return str_replace($order, $replace, $str);

	}


/*
 * export and download all email addess collected to a spreadsheet format
 */
	function export_cvs()
	{

		$sql = "
			SELECT
			visitor_name AS NAME,
			visitor_email AS EMAIL,
			FROM_UNIXTIME(time_submitted) AS TIME_SUBMITTED,
			ip_address AS SUBMIT_IP_ADDRESS
			FROM email_addresses
		";


//		$query = $this->db->query("SELECT * FROM registered_users");
		$query = $this->db->query($sql);
		$this->load->dbutil();

		$delimiter = ",";
		$newline = "\r\n";

		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);

		$this->load->helper('download');
		$filename = 'cafeital_email_addresses.csv';

		force_download($filename, $data);
	}

}
?>
