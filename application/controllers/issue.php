<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Issue controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Issue extends CI_Controller {

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
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('companyReferenceField', 'Company Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('projectTypeRadios', 'Project Type', 'required');
		$this->form_validation->set_rules('clientNameField', 'Client Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('clientEmailField', 'Client Email', 'trim|required|valid_email|xss_clean');

    	if ($this->form_validation->run() == TRUE)
		{
			// Success!
			$name = $this->input->post('clientNameField');
			$email = $this->input->post('clientEmailField');

			// Add client to system
			$this->load->model('clients_model');
			$client_id = $this->clients_model->add_client($name, $email);

			// Create a blank answer set for the chosen project type
			$company_reference = $this->input->post('companyReferenceField');
			$project_type = $this->input->post('projectTypeRadios');

			// Create a new questionnaire
			$this->load->model('questionnaires_model');
			$personalized_url = $this->questionnaires_model->add_questionnaire($company_reference, $client_id, $project_type);

			// Send an invitation to the client
			if ( ! $this->send_invitation($name, $email, $personalized_url))
			{
				$this->session->set_flashdata('message_severity', 'danger');
				$this->session->set_flashdata('message_content', '<strong>Ooops!</strong> Failed to send email.');
			}
			else
			{
				// Set success message and return to admin home
				$this->session->set_flashdata('message_severity', 'success');
				$this->session->set_flashdata('message_content', '<strong>Success!</strong> Questionnaire successfully issued.');
			}

			redirect('dashboard');
		}

        $data = array();

        // Load the view
        $this->layout->set_page_title('Issue New Questionnaire');
        $this->layout->view('dashboard/issue', $data);
    }


    private function send_invitation($client_name, $client_email, $personalized_url)
    {
		$to = $client_email;
		$subject = 'Invitation - ' . $this->config->item('site_name');
    	$message = '';

    	$message .= "Dear {$client_name}," . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "This is a welcome e-mail." . PHP_EOL;
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

}

// END Issue class

/* End of file issue.php */
/* Location: ./application/controllers/issue.php */