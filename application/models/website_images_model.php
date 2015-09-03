<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Website Images model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Website_images_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();
    }


	public function load_website_images($questionnaire_id)
	{
    	// Define the query
    	$this->db->select('wi.id AS website_images_id');
		$this->db->select('wi.bigstock_id AS bigstock_id');
    	$this->db->select('wi.bigstock_thumb AS bigstock_thumb');
    	$this->db->select('wi.bigstock_title AS bigstock_title');

    	$this->db->from('website_images AS wi');
    	$this->db->join('questionnaire_website_images AS qwi', 'qwi.website_images_id = wi.id', 'inner');
    	$this->db->where('qwi.questionnaire_id', $questionnaire_id);
    	$this->db->order_by('wi.id', 'asc');

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		return $query->result();
	}


	public function delete_missing_website_images($website_images, $questionnaire_id)
	{
		// Generate an array of website image ids being updated
		$updated_website_images_ids = array();

		foreach($website_images as $website_image)
		{
			if ($website_image['id'] != 0)
			{
				$updated_website_images_ids[] = $website_image['id'];
			}
		}

		// Generate an array of website image ids currently in the database

		// Define the query
		$this->db->select('website_images_id');
		$this->db->from('questionnaire_website_images');
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		foreach ($query->result() as $row)
		{
			// Delete any current website images not being updated
			if ( ! in_array($row->website_images_id, $updated_website_images_ids))
			{
				// Delete from website images table
				$this->db->where('id', $row->website_images_id);
				$this->db->delete('website_images');

				// Delete from website images lookup table
				$this->db->where('website_images_id', $row->website_images_id);
				$this->db->delete('questionnaire_website_images');
			}
		}
	}


	public function save_website_image($website_image, $questionnaire_id)
	{
		// Insert the new website image

		// Define the query
        $this->db->set('bigstock_id', $website_image['bigstock_id']);
		$this->db->set('bigstock_thumb', $website_image['bigstock_thumb']);
        $this->db->set('bigstock_title', $website_image['bigstock_title']);

		// Run the query
		$this->db->insert('website_images');

		$website_images_id = $this->db->insert_id();

		// Insert the new website image into the linking table

		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);
        $this->db->set('website_images_id', $website_images_id);

		// Run the query
		$this->db->insert('questionnaire_website_images');
	}

}

// END Website_images_model class

/* End of file website_images_model.php */
/* Location: ./application/models/website_images_model.php */