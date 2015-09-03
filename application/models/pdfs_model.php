<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pdfs model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Pdfs_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();
    }


	public function get_output_file_name($questionnaire_id)
	{
		// Define the query
		$this->db->select('questionnaires.company_reference AS company_reference');
		$this->db->from('pdfs');
    	$this->db->join('questionnaires', 'questionnaires.id = pdfs.questionnaire_id', 'inner');
    	$this->db->where('pdfs.questionnaire_id', $questionnaire_id);

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() != 1)
		{
			return false;
		}

		$row = $query->row();

    	return "{$row->company_reference} Design Questionnaire.pdf";
	}


	public function get_last_downloaded($questionnaire_id)
	{
    	// Define the query
    	$this->db->select('pdfs.last_downloaded_date AS date');
    	$this->db->select('users.name AS user');
    	$this->db->join('users', 'users.id = pdfs.last_downloaded_user', 'inner');
    	$this->db->where('pdfs.questionnaire_id', $questionnaire_id);

    	// Run the query
    	$query = $this->db->get('pdfs');

		if ($query->num_rows() != 1)
		{
			return false;
		}

    	return $query->row();
	}


	public function set_last_downloaded($questionnaire_id)
	{
		// Define the query
        $this->db->set('last_downloaded_date', 'NOW()', false);
		$this->db->set('last_downloaded_user', user_id());
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $this->db->update('pdfs');
	}

}

// END Pdfs_model class

/* End of file pdfs_model.php */
/* Location: ./application/models/pdfs_model.php */