<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference Websites model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Reference_websites_model extends CI_Model
{
	// Define tooltip markup
	private $tooltip1 = '<a href="#" class="table-tooltip" data-toggle="tooltip" title="';
	private $tooltip2 = '">';
	private $tooltip3 = '</a>';

	// Define the asset download button
	private $small_button1 = '<a href="';
	private $small_button2 = '" target="';
	private $small_button3 = '" class="btn btn-default btn-xs"><span class="glyphicon ';
	private $small_button4 = '"></span> ';
	private $small_button5 = '</a>';

	// Define symbols for the yes and no responce
	private $competitor_yes = '<span class="glyphicon glyphicon-ok"></span>';
	private $competitor_no = '<span class="glyphicon glyphicon-remove"></span>';

	// Define popover markup for comments
	private $comment_popover1 = '<button type="button" class="btn btn-link table-popover" data-toggle="popover" data-content="';
	private $comment_popover2 = '">';
	private $comment_popover3 = '</button>';
	private $comment_length = 50;


 	public function __construct()
    {
        parent::__construct();

		// The Table Class will auto-generate HTML tables from database result sets
		$this->load->library('table');

		// Store MySQL User-defined variables for use in queries
		$query = $this->db->query("
			SET
				@tooltip1='{$this->tooltip1}',
				@tooltip2='{$this->tooltip2}',
				@tooltip3='{$this->tooltip3}',
				@button1='{$this->small_button1}',
				@button2='{$this->small_button2}',
				@button3='{$this->small_button3}',
				@button4='{$this->small_button4}',
				@button5='{$this->small_button5}',
				@yes='{$this->competitor_yes}',
				@no='{$this->competitor_no}',
				@popover1='{$this->comment_popover1}',
				@popover2='{$this->comment_popover2}',
				@popover3='{$this->comment_popover3}',
				@length='{$this->comment_length}'
			;
		");
    }


	public function reference_websites_table($questionnaire_id)
	{
    	// Define bootstrap table markup
    	$table_open = '<table class="table table-striped" id="%s">';

    	// Set table headings
    	$this->table->set_heading('Website', 'View Site', 'Competitor', 'Comments');

    	// Define the query
    	$this->db->select('CONCAT(@tooltip1, rw.url, @tooltip2, rw.title, @tooltip3) AS website', false);
    	$this->db->select('CONCAT(@button1, rw.url, @button2, "_blank", @button3, "glyphicon-globe", @button4, "Launch", @button5) AS view_site', false);
    	$this->db->select('IF (rw.competitor, @yes, @no) AS competitor', false);
    	$this->db->select('IF (length(rw.comments) > @length, CONCAT(@popover1, rw.comments, @popover2, CONCAT(substring(rw.comments, 1, @length), "..."), @popover3), rw.comments) AS comments', false);
    	$this->db->from('reference_websites AS rw');
    	$this->db->join('questionnaire_reference_websites AS qrw', 'qrw.reference_websites_id = rw.id', 'inner');
    	$this->db->where('qrw.questionnaire_id', $questionnaire_id);
    	$this->db->order_by('rw.competitor', 'asc');
    	$this->db->order_by('rw.id', 'asc');

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
    		// Generate an HTML table from the database query results
    		$this->table->set_template(array('table_open' => sprintf($table_open, 'reference-websites-table')));
    		$html_table = $this->table->generate($query);
		}
		else
		{
			// Define a single cell with a no results message
			$cell = array('data' => 'No Reference Websites', 'class' => 'info', 'colspan' => 4);
			$this->table->add_row($cell);

			$this->table->set_template(array('table_open' => sprintf($table_open, 'reference-websites-table-empty')));
			$html_table = $this->table->generate();
		}

    	return $html_table;
	}


	public function load_reference_websites($questionnaire_id)
	{
    	// Define the query
    	$this->db->select('rw.id AS reference_websites_id');
    	$this->db->select('rw.title AS title', false);
    	$this->db->select('rw.url AS url', false);
    	$this->db->select('rw.competitor AS competitor', false);
    	$this->db->select('rw.comments AS comments', false);

    	$this->db->select('CONCAT(@tooltip1, rw.url, @tooltip2, rw.title, @tooltip3) AS website_html', false);
    	$this->db->select('CONCAT(@button1, rw.url, @button2, "_blank", @button3, "glyphicon-globe", @button4, "Launch", @button5) AS view_site_html', false);
    	$this->db->select('IF (rw.competitor, @yes, @no) AS competitor_html', false);
    	$this->db->select('IF (length(rw.comments) > @length, CONCAT(@popover1, rw.comments, @popover2, CONCAT(substring(rw.comments, 1, @length), "..."), @popover3), rw.comments) AS comments_html', false);

    	$this->db->from('reference_websites AS rw');
    	$this->db->join('questionnaire_reference_websites AS qrw', 'qrw.reference_websites_id = rw.id', 'inner');
    	$this->db->where('qrw.questionnaire_id', $questionnaire_id);
    	$this->db->order_by('rw.competitor', 'desc');
    	$this->db->order_by('rw.id', 'asc');

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		return $query->result();
	}


	public function delete_missing_reference_websites($reference_websites, $questionnaire_id)
	{
		// Generate an array of reference website ids being updated
		$updated_reference_websites_ids = array();

		foreach($reference_websites as $reference_website)
		{
			if ($reference_website['id'] != 0)
			{
				$updated_reference_websites_ids[] = $reference_website['id'];
			}
		}

		// Generate an array of reference website ids currently in the database

		// Define the query
		$this->db->select('reference_websites_id');
		$this->db->from('questionnaire_reference_websites');
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		foreach ($query->result() as $row)
		{
			// Delete any current reference websites not being updated
			if ( ! in_array($row->reference_websites_id, $updated_reference_websites_ids))
			{
				// Delete from reference websites table
				$this->db->where('id', $row->reference_websites_id);
				$this->db->delete('reference_websites');

				// Delete from reference websites lookup table
				$this->db->where('reference_websites_id', $row->reference_websites_id);
				$this->db->delete('questionnaire_reference_websites');
			}
		}
	}


	public function save_reference_website($reference_website, $questionnaire_id)
	{
		// Insert the new reference website

		// Define the query
        $this->db->set('title', $reference_website['title']);
        $this->db->set('url', $reference_website['url']);
        $this->db->set('competitor', $reference_website['competitor']);
        $this->db->set('comments', $reference_website['comments']);

		// Run the query
		$this->db->insert('reference_websites');

		$reference_websites_id = $this->db->insert_id();

		// Insert the new reference website into the linking table

		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);
        $this->db->set('reference_websites_id', $reference_websites_id);

		// Run the query
		$this->db->insert('questionnaire_reference_websites');
	}

}

// END Reference_websites_model class

/* End of file reference_websites_model.php */
/* Location: ./application/models/reference_websites_model.php */