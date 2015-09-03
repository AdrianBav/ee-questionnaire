<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Recently Viewed Questionnaires model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Recently_viewed_questionnaires_model extends CI_Model
{
	// Define the various parts of the company name link
	private $company_link_1 = '<a href="/dashboard/q/';
	private $company_link_2 = '">';
	private $company_link_3 = '</a>';


 	public function __construct()
    {
        parent::__construct();

		// The Table Class will auto-generate HTML tables from database result sets
		$this->load->library('table');

		// Store MySQL User-defined variables for use in queries
		$query = $this->db->query("
			SET
				@link1='{$this->company_link_1}',
				@link2='{$this->company_link_2}',
				@link3='{$this->company_link_3}'
			;
		");
    }


	private function update_recently_viewed($questionnaire_id, $user_id)
	{
		// Define the query
		$this->db->set('viewed_date', 'NOW()', false);
		$this->db->where('questionnaire_id', $questionnaire_id);
		$this->db->where('user_id', $user_id);

		// Run the query
		$this->db->update('recently_viewed_questionnaires');
	}


	private function insert_recently_viewed($questionnaire_id, $user_id)
	{
		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);
        $this->db->set('viewed_date', 'NOW()', false);
		$this->db->set('user_id', $user_id);

		// Run the query
        $this->db->insert('recently_viewed_questionnaires');
	}


	private function trim_recently_viewed($user_id)
	{
		// Get the questionnaire ids of the top 5 most recetly viewed, for the given user
		$this->db->select('id');
		$this->db->from('recently_viewed_questionnaires');
		$this->db->where('user_id', $user_id);
		$this->db->order_by('viewed_date', 'desc');
		$this->db->limit(5);

		// Run the query
		$query = $this->db->get();

		// Store the ids in an array
		$ids = array();

		foreach($query->result() as $row)
		{
			$ids[] = $row->id;
		}

		// Delete all but the top 5 most recetly viewed, for the given user
		$this->db->where('user_id', $user_id);
		$this->db->where_not_in('id', $ids);
		$this->db->delete('recently_viewed_questionnaires');
	}


	public function add_recently_viewed($questionnaire_id, $user_id)
	{
		// Determine if the questionnaire being viewed is already in the table
    	$this->db->where('questionnaire_id', $questionnaire_id);
    	$this->db->where('user_id', $user_id);
    	$this->db->from('recently_viewed_questionnaires');

    	if ($this->db->count_all_results())
    	{
    		// Update the view date
    		$this->update_recently_viewed($questionnaire_id, $user_id);
    	}
    	else
    	{
    		// Insert a new record and tidy the table
    		$this->insert_recently_viewed($questionnaire_id, $user_id);
    		$this->trim_recently_viewed($user_id);
    	}
	}


	public function recently_viewed_table($user_id)
	{
    	// Define bootstrap table markup
    	$table_open = '<table class="table table-condensed table-striped" id="%s">';

    	// Set table headings
    	$this->table->set_heading('Company Name', 'Project Type', 'Viewed');

    	// Define the query
    	$this->db->select('CONCAT(@link1, questionnaires.id, @link2, questionnaires.company_reference, @link3)', false);
    	$this->db->select('questionnaires.project_type');
    	$this->db->select('rvq.viewed_date');

    	$this->db->from('recently_viewed_questionnaires AS rvq');
    	$this->db->join('questionnaires', 'questionnaires.id = rvq.questionnaire_id', 'inner');
    	$this->db->where('rvq.user_id', $user_id);
    	$this->db->order_by('rvq.viewed_date', 'desc');
    	$this->db->limit(5);

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
    		// Generate an HTML table from the database query results
    		$this->table->set_template(array('table_open' => sprintf($table_open, 'recently-viewed-table')));
    		$html_table = $this->table->generate($query);
		}
		else
		{
			// Define a single cell with a no results message
			$cell = array('data' => 'No recently viewed questionnaires', 'class' => 'info', 'colspan' => 3);
			$this->table->add_row($cell);

			// Generate an HTML table
			$this->table->set_template(array('table_open' => sprintf($table_open, 'recently-viewed-table-empty')));
			$html_table = $this->table->generate();
		}

    	return $html_table;
	}

}

// END Recently_viewed_questionnaires_model class

/* End of file recently_viewed_questionnaires_model.php */
/* Location: ./application/models/recently_viewed_questionnaires_model.php */