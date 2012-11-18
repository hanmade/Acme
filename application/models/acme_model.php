<?php
//model for the acme scafolding

class Acme_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->time_submitted	= time();
        $this->ip_address		= $_SERVER['REMOTE_ADDR'];
    }
/*
 * functions for the registered users
 */
	function get_10_users()
	{
		$this->db->limit(10, 0);
		$query = $this->db->get('registered_users');
		return $query->result();
	}

    function delete_user($id)
    {
    	$query = $this->db->delete('registered_users', array('id' => $id));
    	return $query;
    }

    function get_paginiated_users($limit, $page)
    {
    	$this->db->limit($limit, $page);
		$query = $this->db->get('registered_users');
    	return $query->result();
    }

    function get_users($sort, $order)
    {
//	  	echo $sort." ".$order;die();
    	$this->db->order_by($sort, $order);
		$query = $this->db->get('registered_users');
    	return $query->result();
    }

    function get_user_count()
    {
    	$query = $this->db->get('registered_users');
    	return $query->num_rows();
    }

    function make_users()
    {
    	$sql = "DROP TABLE registered_users";
    	$result = $this->db->query($sql);

    	$sql = "
    	CREATE TABLE registered_users
    	(
    		id INT DEFAULT NULL AUTO_INCREMENT,
			date_modified TIMESTAMP,
			ip_address VARCHAR(15),
			email_address VARCHAR(30),
			f_name VARCHAR(30),
			l_name VARCHAR(30),
			address_1 VARCHAR(100),
			address_2 VARCHAR(100),
			city VARCHAR(20),
			state VARCHAR(20),
			zip VARCHAR(10),
			home_phone  VARCHAR(15),
			mobile_phone  VARCHAR(15),
	    	PRIMARY				KEY (id)
    	);";

    	$result = $this->db->query($sql);

    	$handle = fopen("C:\\www\\acme\\names.csv", "r");
    	$streets = array('Elm','Pine','Maple','Oak','Beech','Ash','Willow','Birch','Sequoia','Cedar');
		$street_types = array('St','Rd','Ln','Pl','Blvd');
		$cities = array('Acworth','Albany','Alexandria','Allenstown','Alstead','Alton','Amherst','Andover','Antrim','Ashland',
'Atkinson','Auburn','Barnstead','Barrington','Bartlett','Bath','Bedford','Belmont','Bennington','Benton',
'Berlin','Bethlehem','Boscawen','Bow','Bradford','Brentwood','Bridgewater','Bristol','Brookfield','Brookline');
		$states = array(
				'AL','AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID',
				'IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO',
				'MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA',
				'RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY',
				);


		while (($data = fgetcsv($handle, 100, ",")) !== FALSE)
		{
	//    echo "got here"; die();
			$f_name = ucfirst($data[1]);
			$l_name = ucfirst($data[2]);
			$classA = rand(1,127);
			$classB = rand(0,255);
			$classC = rand(0,255);
			$classD = rand(0,255);
			$ip = $classA.".".$classB.".".$classC.".".$classD;
			$email = strtolower($data[1]).strtolower($data[2])."@gmail.com";
			shuffle($streets);
			shuffle($street_types);
			$anum = rand(100, 500);
			$address_1 = $anum." ".$streets[0]." ".$street_types[0];
			$address_2 = '';
			shuffle($cities);
			$city = $cities[0];
			shuffle($states);
			$state = $states[0];
			$zip = rand(0,99999);
			$zip = sprintf('%05d',$zip);
			$mobile_phone = '555-555-5555';
			$home_phone = '444-444-4444';
		    $sql =
			"INSERT INTO registered_users VALUES (".
		 	"NULL,".
		 	"NULL,".
		    "'".$ip."',".
		 	"'".$email."',".
		 	"'".$f_name."',".
		    "'".$l_name."',".
		    "'".$address_1."',".
		    "'".$address_2."',".
		    "'".$city."',".
		    "'".$state."',".
		    "'".$zip."',".
		    "'".$home_phone."',".
		    "'".$mobile_phone."');";
/*
		    id INT DEFAULT NULL AUTO_INCREMENT,
		    date_modified TIMESTAMP,
		    ip_address VARCHAR(15),
		    email_address VARCHAR(30),
		    f_name VARCHAR(30),
		    l_name VARCHAR(30),
		    address_1 VARCHAR(100),
		    address_2 VARCHAR(100),
		    city VARCHAR(20),
		    state VARCHAR(20),
		    zip VARCHAR(10),
		    home_phone  VARCHAR(15),
		    mobile_phone  VARCHAR(15),
		    PRIMARY				KEY (id)
*/

//		   echo $sql."<br>";
		   $result = $this->db->query($sql);

		}

		redirect('/admin/registered_users/ulist');
    }
/*
 * old stuff from cafeital
 */
    function get_initial_weekend_images()
    {
    	$sql = "SELECT * FROM weekend_special WHERE is_test = 0 AND is_live = 0 AND is_archived = 0";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_test_weekend_images()
    {
    	$sql = "SELECT * FROM weekend_special WHERE is_test = 1 AND is_live = 0 AND is_archived = 0";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_live_weekend_image()
    {
    	$sql = "SELECT * FROM weekend_special WHERE is_test = 1 AND is_live = 1 AND is_archived = 0 LIMIT 1";
    	$query = $this->db->query($sql);
    	return $query->row();
    }

    function get_archived_weekend_images()
    {
    	$sql = "SELECT * FROM weekend_special WHERE is_test = 1 AND is_live = 1 AND is_archived = 1";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function insert_weekend_image_record($data)
    {
    	return $this->db->insert('weekend_special', $data);
    }

    function get_weekend_image_row($id)
    {
    	$this->db->where('id', $id);
    	$query = $this->db->get('weekend_special');
    	return $query->row();
    }

    function update_weekend_image_name($data, $id)
    {
    	$this->db->where('id', $id);
    	return $this->db->update('weekend_special', $data);
    }

    function update_weekend_image_record($data, $id)
    {
    	$this->db->where('id', $id);
    	//		print_r($data); die();

    	return $this->db->update('weekend_special', $data);
    }

    function delete_weekend_image($id)
    {
    	return $this->db->delete('weekend_special', array('id' => $id));
    }
/*
 * functions for email addresses
 */
    function insert_email_address($data)
    {
    	return $this->db->insert('email_addresses', $data);
    }

    function update_email_address($data, $id)
    {
//    	exit('got to model');
    	$this->db->where('id', $id);
    	return $this->db->update('email_addresses', $data);
    }

    function get_email_addresses()
    {
    	$sql = "SELECT * FROM email_addresses";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_email_addresses_row($id)
    {
    	$this->db->where('id', $id);
    	$query = $this->db->get('email_addresses');
    	return $query->row();
    }

    function delete_email_address($id)
    {
    	return $this->db->delete('email_addresses', array('id' => $id));
    }

    /*
     * functions for the gallery images
     * XXX all need error handling
    */

    function delete_gallery_image($id)
    {
    	return $this->db->delete('gallery_images', array('id' => $id));
    }

    function get_gallery_image_row($id)
    {
    	$this->db->where('id', $id);
    	$query = $this->db->get('gallery_images');
    	return $query->row();
    }

    function get_gallery_images()
    {
    	$sql = "SELECT * FROM gallery_images";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_initial_gallery_images()
    {
    	$sql = "SELECT * FROM gallery_images WHERE is_test = 0 AND is_live = 0 AND is_archived = 0";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_test_gallery_images()
    {
    	$sql = "SELECT * FROM gallery_images WHERE is_test = 1 AND is_live = 0 AND is_archived = 0";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_live_gallery_images_count()
    {
    	$sql = "SELECT * FROM gallery_images WHERE is_test = 1 AND is_live = 1 AND is_archived = 0";
    	$query = $this->db->query($sql);
    	return $query->num_rows();
    }


    function get_live_gallery_images()
    {
    	$sql = "SELECT * FROM gallery_images WHERE is_test = 1 AND is_live = 1 AND is_archived = 0 ORDER BY display_order ASC";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function get_archived_gallery_images()
    {
    	$sql = "SELECT * FROM gallery_images WHERE is_test = 1 AND is_live = 1 AND is_archived = 1";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    function update_gallery_image_name($data, $id)
    {
    	$this->db->where('id', $id);
    	return $this->db->update('gallery_images', $data);
    }

    function insert_gallery_image_record($data)
    {
    	return $this->db->insert('gallery_images', $data);
    }

    function update_gallery_image_record($data, $id)
    {
    	$this->db->where('id', $id);
    	//		print_r($data); die();

    	return $this->db->update('gallery_images', $data);
    }

/*
 * fetch and return the row with the changable content
 */
	function get_content_row()
	{
		$query = $this->db->get('content_fields');
		return $query->row();
	}

	function update_content($id, $udata)
	{
		$this->db->where('id', $id);
//		print_r($udata['weekend_specials_text']);die();

		if(!$this->db->update('content_fields', $udata))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}
/*
 * main routine here
 * @author shp 2-29.12
 * check if email empty
 * check if email is in db
 * insert with timestamp, IP address and dupe count
 */
	function push($data)
	{

		$pushdata = array(
			'visitor_name' => $data['visitor_name'],
			'visitor_email' => $data['visitor_email'],
			'time_submitted' => $this->time_submitted,
			'ip_address' => $this->ip_address
		);

		if(!$this->db->insert('email_addresses', $pushdata))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}
}
/*
 * Created on Feb 29, 2012
 *
 * File name: Cafe_model.php
 * Project: cafeitaliano
 */


