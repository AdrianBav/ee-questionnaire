<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Users_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();
    }


	public function validate_user_credentials($email, $password)
	{
		// Define the query
		$this->db->select('id');
		$this->db->select('name');
		$this->db->select('email');

        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->from('users');

		// Run the query
        $query = $this->db->get();

        // Success is defined as returning exactly one result
        if ($query->num_rows != 1)
        {
        	return false;
        }

		// Extract the user data and store in a session
		$row = $query->row();

		$data = array(
			'id' => $row->id,
			'name' => $row->name,
			'email' => $row->email,
			'validated' => true
		);
		$this->session->set_userdata($data);

		// Validation succeeded
		return true;
	}

}

// END Users_model class

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */