<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Questionnaires model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Questionnaires_model extends CI_Model
{
	// Define the various parts of the company name link
	private $company_link_1 = '<a href="/dashboard/q/';
	private $company_link_2 = '">';
	private $company_link_3 = '</a>';

	// Define each site of the pie chart markup
	private $pie1 = '<span class="pie">';
	private $pie2 = '/100</span>';


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
				@link3='{$this->company_link_3}',
				@pie1='{$this->pie1}',
				@pie2='{$this->pie2}'
			;
		");
    }


    public function questionnaires_table()
    {
    	// Define bootstrap table markup
    	$table_open = '<table class="table table-striped table-bordered table-hover" id="%s">';

    	// Set table headings
    	$this->table->set_heading('Company Name', 'Project Type', 'Issued', 'Progress', 'Returned');

    	// Define the query
    	$this->db->select('CONCAT(@link1, id, @link2, company_reference, @link3) AS company_name', false);
    	$this->db->select('project_type');
    	$this->db->select('issued_date');
    	$this->db->select('CONCAT(@pie1, progress, @pie2, " ", progress, "%") AS progress', false);
    	$this->db->select('returned_date');
    	$this->db->from('questionnaires');
    	$this->db->order_by('company_name', 'asc');

    	// Run the query
    	$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
    		// Generate an HTML table from the database query results
    		$this->table->set_template(array('table_open' => sprintf($table_open, 'questionnaires-table')));
    		$html_table = $this->table->generate($query);
		}
		else
		{
			// Define a single cell with a no results message
			$cell = array('data' => 'No Questionnaires', 'class' => 'info', 'colspan' => 5);
			$this->table->add_row($cell);

			// Generate an HTML table
			$this->table->set_template(array('table_open' => sprintf($table_open, 'questionnaires-table-empty')));
			$html_table = $this->table->generate();
		}

    	return $html_table;
    }


	public function recently_returned_table()
	{
    	// Define bootstrap table markup
    	$table_open = '<table class="table table-condensed table-striped" id="%s">';

    	// Set table headings
    	$this->table->set_heading('Company Name', 'Project Type', 'Returned');

    	// Define the query
    	$this->db->select('CONCAT(@link1, id, @link2, company_reference, @link3) AS company_reference', false);
    	$this->db->select('project_type');
    	$this->db->select('returned_date');

    	$this->db->from('questionnaires');
    	$this->db->where('returned_date !=', 'NULL');
    	$this->db->order_by('returned_date', 'desc');
    	$this->db->order_by('id', 'desc');
    	$this->db->limit(5);

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
    		// Generate an HTML table from the database query results
    		$this->table->set_template(array('table_open' => sprintf($table_open, 'recently-returned-table')));
    		$html_table = $this->table->generate($query);
		}
		else
		{
			// Define a single cell with a no results message
			$cell = array('data' => 'No recently returned questionnaires', 'class' => 'info', 'colspan' => 3);
			$this->table->add_row($cell);

			// Generate an HTML table
			$this->table->set_template(array('table_open' => sprintf($table_open, 'recently-returned-table-empty')));
			$html_table = $this->table->generate();
		}

    	return $html_table;
	}


	public function get_questionnaire($questionnaire_id)
	{
    	// Define the query
    	$this->db->select('questionnaires.company_reference AS company_reference');
    	$this->db->select('clients.name AS client_name');
    	$this->db->select('clients.email AS client_email');
    	$this->db->select('clients.last_activity');
    	$this->db->select('questionnaires.personalized_slug AS personalized_slug');
    	$this->db->select('questionnaires.project_type AS project_type');
    	$this->db->select('users.name AS issued_by_name');
    	$this->db->select('users.email AS issued_by_email');
    	$this->db->select('questionnaires.issued_date');
    	$this->db->select('questionnaires.progress AS progress');
    	$this->db->select('questionnaires.returned_date AS returned_date');

    	$this->db->from('questionnaires');
    	$this->db->join('clients', 'clients.id = questionnaires.client_id', 'outer left');
    	$this->db->join('users', 'users.id = questionnaires.issued_by', 'outer left');
    	$this->db->where('questionnaires.id', $questionnaire_id);

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() != 1)
		{
			return false;
		}

    	return $query->row();
	}


	public function add_questionnaire($company_reference, $client_id, $project_type)
	{
		// Generate a unique personalized slug
		$personalized_slug = uniqid();

		// Define the query
        $this->db->set('company_reference', $company_reference);
		$this->db->set('client_id', $client_id);
		$this->db->set('personalized_slug', $personalized_slug);
		$this->db->set('project_type', $project_type);
		$this->db->set('issued_by', user_id());
		$this->db->set('issued_date', 'NOW()', FALSE);

		// Run the query
        $this->db->insert('questionnaires');

        // Build and return the customers personalized URL
        $personalized_url = site_url("go/{$personalized_slug}");
        return $personalized_url;
	}


	public function get_questionnaire_progress($personalized_slug)
	{
    	// Define the query
    	$this->db->select('questionnaires.id AS questionnaire_id');
    	$this->db->select('clients.id AS client_id');
    	$this->db->select('clients.name AS client_name');
		$this->db->select('questionnaires.progress AS progress');

    	$this->db->from('questionnaires');
    	$this->db->join('clients', 'clients.id = questionnaires.client_id', 'inner');
    	$this->db->where('questionnaires.personalized_slug', $personalized_slug);

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() != 1)
		{
			return false;
		}

    	return $query->row();
	}


	public function set_questionnaire_progress($questionnaire_id, $progress)
	{
		// Define the query
		if ($progress == 100)
		{
			// On completing the questionnaire, set the return date to today.
			$this->db->set('returned_date', 'NOW()', FALSE);
		}
		$this->db->set('progress', $progress);
		$this->db->where('id', $questionnaire_id);

		// Run the query
		$this->db->update('questionnaires');
	}

}

// END Questionnaires_model class

/* End of file questionnaires_model.php */
/* Location: ./application/models/questionnaires_model.php */