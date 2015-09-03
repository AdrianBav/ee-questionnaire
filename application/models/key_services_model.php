<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Key Services model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Key_services_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();
    }


	public function get_total_key_services($questionnaire_id)
	{
		// Define the query
		$this->db->select('COUNT(*) AS total', false);
		$this->db->from('key_services');
		$this->db->join('questionnaire_key_services', 'questionnaire_key_services.key_services_id = key_services.id', 'inner');
		$this->db->where('questionnaire_key_services.questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		$row = $query->row();
		return $row->total;
	}


	public function load_key_services($questionnaire_id)
	{
		// Define the query
		$this->db->select('key_services.id AS key_services_id');
		$this->db->select('key_services.service AS service');
		$this->db->select('key_services.description AS description');

		$this->db->from('key_services');
		$this->db->join('questionnaire_key_services', 'questionnaire_key_services.key_services_id = key_services.id', 'inner');
		$this->db->where('questionnaire_key_services.questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		return $query->result();
	}


	public function delete_missing_key_services($key_services, $questionnaire_id)
	{
		// Generate an array of key service ids being updated
		$updated_key_services_ids = array();

		foreach($key_services as $key_service)
		{
			if ($key_service['id'] != 0)
			{
				$updated_key_services_ids[] = $key_service['id'];
			}
		}

		// Generate an array of key service ids currently in the database

		// Define the query
		$this->db->select('key_services_id');
		$this->db->from('questionnaire_key_services');
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		foreach ($query->result() as $row)
		{
			// Delete any current key services not being updated
			if ( ! in_array($row->key_services_id, $updated_key_services_ids))
			{
				// Delete from key services table
				$this->db->where('id', $row->key_services_id);
				$this->db->delete('key_services');

				// Delete from key services lookup table
				$this->db->where('key_services_id', $row->key_services_id);
				$this->db->delete('questionnaire_key_services');
			}
		}
	}


	public function save_key_service($key_service, $questionnaire_id)
	{
		// Insert the new key service

		// Define the query
        $this->db->set('service', $key_service['service']);
        $this->db->set('description', $key_service['description']);

		// Run the query
		$this->db->insert('key_services');

		$key_services_id = $this->db->insert_id();

		// Insert the new key service into the linking table

		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);
        $this->db->set('key_services_id', $key_services_id);

		// Run the query
		$this->db->insert('questionnaire_key_services');
	}

}

// END Key_services_model class

/* End of file key_services_model.php */
/* Location: ./application/models/key_services_model.php */