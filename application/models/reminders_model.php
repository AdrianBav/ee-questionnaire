<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reminders model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Reminders_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();

		// The Table Class will auto-generate HTML tables from database result sets
		$this->load->library('table');
    }


	public function get_reminders_table($questionnaire_id)
	{
    	// Define bootstrap table markup
    	$table_open = '<table class="table table-striped table-bordered table-hover" id="%s">';

    	// Set table headings
    	$this->table->set_heading('Reminder Sent', 'Sent By');

    	// Query the database
    	$this->db->select('reminders.date_sent AS date_sent');
    	$this->db->select('IF(reminders.sent_by=0, "System", users.name) AS sent_by', false);
    	$this->db->join('users', 'users.id = reminders.sent_by', 'left outer');
    	$this->db->where('reminders.questionnaire_id', $questionnaire_id);
    	$this->db->order_by('date_sent', 'desc');
    	$query = $this->db->get('reminders');

		if ($query->num_rows() > 0)
		{
    		// Generate an HTML table from the database query results
    		$this->table->set_template(array('table_open' => sprintf($table_open, 'reminders-table')));
    		$html_table = $this->table->generate($query);
		}
		else
		{
			// Define a single cell with a no results message
			$cell = array('data' => 'No Reminders', 'class' => 'info', 'colspan' => 2);
			$this->table->add_row($cell);

			// Generate an HTML table
			$this->table->set_template(array('table_open' => sprintf($table_open, 'reminders-table-empty')));
			$html_table = $this->table->generate();
		}

    	return $html_table;
	}


	public function add_reminder($questionnaire_id, $sent_by = 0)
	{
		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);
		$this->db->set('date_sent', 'NOW()', false);
		$this->db->set('sent_by', $sent_by);

		// Run the query
        $this->db->insert('reminders');
	}

}

// END Reminders_model class

/* End of file reminders_model.php */
/* Location: ./application/models/reminders_model.php */