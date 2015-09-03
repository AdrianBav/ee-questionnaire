<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Project Assets model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Project_assets_model extends CI_Model
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
				@popover1='{$this->comment_popover1}',
				@popover2='{$this->comment_popover2}',
				@popover3='{$this->comment_popover3}',
				@length='{$this->comment_length}'
			;
		");
    }


	public function project_assets_table($questionnaire_id)
	{
    	// Define bootstrap table markup
    	$table_open = '<table class="table table-striped" id="%s">';

    	// Set table headings
    	$this->table->set_heading('Title', 'Download Asset', 'Last Downloaded', 'Comments');

    	// Define the query
    	$this->db->select('CONCAT(@tooltip1, pa.filename, @tooltip2, pa.title, @tooltip3) AS title', false);
    	$this->db->select('CONCAT(@button1, "/dashboard/pa/", pa.id, @button2, "_self", @button3, "glyphicon-save", @button4, "Download", @button5) AS download_asset', false);
    	$this->db->select('IF (pa.last_downloaded_date, CONCAT(@tooltip1, "by ", u.name, @tooltip2, pa.last_downloaded_date, @tooltip3), "-") AS last_downloaded', false);
    	$this->db->select('IF (length(pa.comments) > @length, CONCAT(@popover1, pa.comments, @popover2, CONCAT(substring(pa.comments, 1, @length), "..."), @popover3), comments)', false);

    	$this->db->from('project_assets AS pa');
    	$this->db->join('users AS u', 'u.id = pa.last_downloaded_user', 'left outer');
    	$this->db->join('questionnaire_project_assets AS qpa', 'qpa.project_assets_id = pa.id', 'inner');
    	$this->db->where('qpa.questionnaire_id', $questionnaire_id);
    	$this->db->order_by('pa.last_downloaded_date', 'desc');

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
    		// Generate an HTML table from the database query results
    		$this->table->set_template(array('table_open' => sprintf($table_open, 'project-assets-table')));
    		$html_table = $this->table->generate($query);
		}
		else
		{
			// Define a single cell with a no results message
			$cell = array('data' => 'No Project Assets', 'class' => 'info', 'colspan' => 4);
			$this->table->add_row($cell);

			// Generate an HTML table
			$this->table->set_template(array('table_open' => sprintf($table_open, 'project-assets-table-empty')));
			$html_table = $this->table->generate();
		}

    	return $html_table;
	}


	public function load_project_assets($questionnaire_id)
	{
    	// Define the query
    	$this->db->select('pa.id AS project_asset_id');
		$this->db->select('pa.title AS title');
    	$this->db->select('pa.filename AS filename');
    	$this->db->select('IF (length(pa.comments) > @length, CONCAT(@popover1, pa.comments, @popover2, CONCAT(substring(pa.comments, 1, @length), "..."), @popover3), pa.comments) AS comments', false);

    	$this->db->from('project_assets AS pa');
    	$this->db->join('questionnaire_project_assets AS qpa', 'qpa.project_assets_id = pa.id', 'inner');
    	$this->db->where('qpa.questionnaire_id', $questionnaire_id);
    	$this->db->order_by('pa.id', 'asc');

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() < 1)
		{
		   return false;
		}

		return $query->result();
	}


	public function get_project_asset($project_asset_id)
	{
		// Define the query
		$this->db->select('project_assets.filename AS filename');
		$this->db->select('project_assets.mimetype AS mimetype');
		$this->db->select('questionnaire_project_assets.questionnaire_id AS questionnaire_id');

		$this->db->from('project_assets');
    	$this->db->join('questionnaire_project_assets', 'questionnaire_project_assets.project_assets_id = project_assets.id', 'inner');
    	$this->db->where('project_assets.id', $project_asset_id);

    	// Run the query
    	$query = $this->db->get();

		if ($query->num_rows() != 1)
		{
			return false;
		}

    	return $query->row();
	}


	public function set_last_downloaded($project_asset_id)
	{
		// Define the query
        $this->db->set('last_downloaded_date', 'NOW()', false);
		$this->db->set('last_downloaded_user', user_id());
		$this->db->where('id', $project_asset_id);

		// Run the query
        $this->db->update('project_assets');
	}


	public function add_project_asset($questionnaire_id, $data)
	{
		// Define the query
        $this->db->set('title', $data['title']);
		$this->db->set('filename', $data['filename']);
		$this->db->set('mimetype', $data['mimetype']);
		$this->db->set('comments', $data['comments']);

		// Run the query
        $this->db->insert('project_assets');

        // Return the id of the inserted row
        $project_assets_id =  $this->db->insert_id();

		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);
        $this->db->set('project_assets_id', $project_assets_id);

		// Run the query
        $this->db->insert('questionnaire_project_assets');
	}


	public function remove_project_asset($project_asset_id)
	{
		// Define the query
		$this->db->where('id', $project_asset_id);

		// Run the query
		$this->db->delete('project_assets');

		return $this->db->affected_rows();
	}

}

// END Project_assets_model class

/* End of file project_assets_model.php */
/* Location: ./application/models/project_assets_model.php */