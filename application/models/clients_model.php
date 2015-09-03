<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clients model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Clients_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();
    }


	public function add_client($name, $email)
	{
		// Define the query
        $this->db->set('name', $name);
		$this->db->set('email', $email);

		// Run the query
        $this->db->insert('clients');

        // Return the id of the inserted row
        return $this->db->insert_id();
	}


	public function update_client_last_activity($client_id)
	{
		// Define the query
		$this->db->set('last_activity', 'NOW()', FALSE);
		$this->db->where('id', $client_id);

		// Run the query
		$this->db->update('clients');
	}

}

// END Clients_model class

/* End of file clients_model.php */
/* Location: ./application/models/clients_model.php */