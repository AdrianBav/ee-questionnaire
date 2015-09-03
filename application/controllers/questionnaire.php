<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Questionnaire controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Questionnaire extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// user must be logged in to view this page
		if ( ! is_logged_in())
		{
			redirect('/');
		}
	}


    private function send_reminder($questionnaire)
    {
    	$client_name = $questionnaire->client_name;
    	$client_email = $questionnaire->client_email;
    	$personalized_slug = $questionnaire->personalized_slug;
    	$issued_date = $questionnaire->issued_date;
    	$progress = $questionnaire->progress;

		// Generate the personalized url
	    $personalized_url = site_url("go/{$personalized_slug}");

	    $to = $client_email;
	    $subject  = 'Questionnaire Reminder - ' . $this->config->item('site_name');
	    $message = '';

		// Compose the message
    	$message .= "Dear {$client_name}," . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "This is a reminder e-mail." . PHP_EOL;
    	$message .= "Your questionnaire was issued on {$issued_date} and is {$progress}% complete." . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "Please follow the link below and fill out the Website Design Questionnaire." . PHP_EOL;
    	$message .= "{$personalized_url}" . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "Thanks," . PHP_EOL;
    	$message .= $this->config->item('site_name');

    	// Send the email
		$this->load->helper('email');
		$result = send_email($to, $subject, $message);

		return $result;
    }


    public function index($questionnaire_id = 0)
    {
    	if ( ! $questionnaire_id)
    	{
    		redirect('/dashboard');
    	}

        $this->load->model(array('questionnaires_model', 'recently_viewed_questionnaires_model', 'reminders_model', 'reference_websites_model', 'project_assets_model'));
        $data = array();

        // Load questionnaire details
        $questionnaire = $this->questionnaires_model->get_questionnaire($questionnaire_id);

        if ( ! $questionnaire)
        {
        	redirect('/dashboard');
        }

        $data['questionnaire_id'] = $questionnaire_id;
        $data['questionnaire_data'] = $questionnaire;
        $data['questionnaire_complete'] = ($questionnaire->progress == 100) ? true : false;

        // Check for any previous message
        if ($this->session->flashdata('message_content')) {

			$data['severity'] = ($this->session->flashdata('message_severity')) ? $this->session->flashdata('message_severity') : 'info';
			$data['message'] = $this->session->flashdata('message_content');
        }

        // COMPLETE
        if ($data['questionnaire_complete'])
        {
        	$view_data = array();

        	// Load Questionnaire details
        	$view_data['questionnaire_details'] = $questionnaire;

			// Load and format cms answers
    		$this->load->model('cms_answers_model');
    		$cms_answers = $this->cms_answers_model->load_cms_answers($questionnaire_id);
	    	$view_data['cms_answers'] = $this->cms_answers_model->format_cms_answers($cms_answers);

	    	// Load key services
	    	$this->load->model('key_services_model');
	    	$view_data['key_services'] = $this->key_services_model->load_key_services($questionnaire_id);

	    	// Load reference websites
	    	$this->load->model('reference_websites_model');
	    	$view_data['reference_websites'] = $this->reference_websites_model->load_reference_websites($questionnaire_id);

	    	// Load website images
	    	$this->load->model('website_images_model');
	    	$view_data['website_images'] = $this->website_images_model->load_website_images($questionnaire_id);

	    	// Load the view
	    	$questionnaire_answers = $this->load->view('pdf/cms', $view_data, TRUE);
        	$data['questionnaire_answers'] = $questionnaire_answers;

        	// Find out if the PDF exists yet
        	$filepath = FCPATH . "downloads/pdfs/q{$questionnaire_id}.pdf";
        	$data['pdf_exists'] = $pdf_exists = (file_exists($filepath)) ? TRUE : FALSE;

        	// Get last downloaded details
        	$data['downloaded_date'] = '';
        	$data['downloaded_by'] = '';

        	if ($pdf_exists)
        	{
	        	$this->load->model('pdfs_model');
	        	$last_downloaded = $this->pdfs_model->get_last_downloaded($questionnaire_id);

	        	if ($last_downloaded)
	        	{
		        	$data['downloaded_date'] = $last_downloaded->date;
		        	$data['downloaded_by'] = $last_downloaded->user;
	        	}
        	}

        	// Load data for tables
        	$data['reference_websites_table'] = $this->reference_websites_model->reference_websites_table($questionnaire_id);
        	$data['project_assets_table'] = $this->project_assets_model->project_assets_table($questionnaire_id);
        }

        // IN PROGRESS
		if ( ! $data['questionnaire_complete'])
		{
	    	$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
			$this->form_validation->set_message('required', 'Please confirm you understand.');

			$this->form_validation->set_rules('confirmField', 'Confirm', 'trim|required');

	    	if ($this->form_validation->run() == TRUE)
	    	{
	    		// Send a reminder to the client
				if ( ! $this->send_reminder($questionnaire))
				{
					$data['severity'] = 'danger';
					$data['message'] = '<strong>Ooops!</strong> Failed to send email.';
				}
				else
				{
		    		// Add to database
					$this->reminders_model->add_reminder($questionnaire_id, user_id());

					// Set success message and return to admin home
					$data['severity'] = 'success';
					$data['message'] = '<strong>Success!</strong> Reminder successfully sent.';
				}
	    	}

	        // Load On-Off switch resources
			$this->layout->add_stylesheet('/assets/css/toggle-switch.css');
		}

        // Load the reminders
        $data['reminders_table'] = $this->reminders_model->get_reminders_table($questionnaire_id);

        // Add this questionnaire to the recently viewed
        $this->recently_viewed_questionnaires_model->add_recently_viewed($questionnaire_id, user_id());

		// Load Moment.js and Relative Time resources
		$this->layout->add_script('/assets/js/momentJs/moment.min.js');
		$this->layout->add_script('/assets/js/relativeTime.js');

		// General dashboard style and script
		$this->layout->add_stylesheet('/assets/css/dashboard.css');

        // Load the view
        $this->layout->set_page_title('View Questionnaire');
        $this->layout->view('dashboard/questionnaire', $data);
    }

}

// END Questionnaire class

/* End of file questionnaire.php */
/* Location: ./application/controllers/questionnaire.php */