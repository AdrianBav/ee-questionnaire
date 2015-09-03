<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dashboard controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// user must be logged in to view this page
		if ( ! is_logged_in())
		{
			redirect('/');
		}
	}


    public function index()
    {
        $data = array();
        $this->load->model(array('questionnaires_model', 'recently_viewed_questionnaires_model'));

        // Check for any previous message
        if ($this->session->flashdata('message_content'))
        {
        	$data['severity'] = ($this->session->flashdata('message_severity')) ? $this->session->flashdata('message_severity') : 'info';
        	$data['message'] = $this->session->flashdata('message_content');
        }

        // Load data for tables
		$data['recently_returned_table'] = $this->questionnaires_model->recently_returned_table();
		$data['recently_viewed_table'] = $this->recently_viewed_questionnaires_model->recently_viewed_table(user_id());
		$data['questionnaires_table'] = $this->questionnaires_model->questionnaires_table();

		// Load Chart.js resources
		$this->layout->add_script('/assets/js/chartJs/chart.min.js');

		// Load Moment.js and Relative Time resources
		$this->layout->add_script('/assets/js/momentJs/moment.min.js');
		$this->layout->add_script('/assets/js/relativeTime.js');

		// Load Peity resources
		$this->layout->add_script('/assets/js/peity/jquery.peity.min.js');

        // Load DataTables resources
		$this->layout->add_stylesheet('/assets/css/dataTables/dataTables.bootstrap.css');
		$this->layout->add_script('/assets/js/dataTables/jquery.dataTables.js');
		$this->layout->add_script('/assets/js/dataTables/dataTables.bootstrap.js');

		// General dashboard style and script
		$this->layout->add_stylesheet('/assets/css/dashboard.css');
		$this->layout->add_script('/assets/js/dashboard.js');

        // Load the view
        $this->layout->set_page_title('Dashboard');
        $this->layout->view('dashboard/home', $data);
    }


    public function charts()
    {
    	$data = array();
    	$this->load->model('charts_model');

    	// Get the chart data from the model as a JSON object.
    	$chart_data = $this->charts_model->get_chart_data();
    	$data['json_data'] = json_encode($chart_data);

    	// Send the JSON to the browser.
    	$this->load->view('dashboard/json', $data);
    }


    public function server_date()
    {
    	$data = array();

    	// Get the current server date as a JSON object.
    	$current_server_date = array('server_date' => date("Y-m-d H:i:s"));
    	$data['json_data'] = json_encode($current_server_date);

    	// Send the JSON to the browser.
    	$this->load->view('dashboard/json', $data);
    }

}

// END Dashboard class

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */