<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Questions controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Questions extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('cms_answers_model', 'key_services_model', 'reference_websites_model', 'website_images_model'));
		$this->load->helper('form');
	}


    private function process_key_services($company_key_services, $questionnaire_id)
    {
    	if ( ! $company_key_services)
    	{
    		return FALSE;
    	}

		// Delete key services
		$this->key_services_model->delete_missing_key_services($company_key_services, $questionnaire_id);

		// Save key services
		foreach($company_key_services as $company_key_service)
		{
			// Only save new website images
			if ($company_key_service['id'] == 0)
			{
				$this->key_services_model->save_key_service($company_key_service, $questionnaire_id);
			}
		}

		return TRUE;
    }


    private function process_website_function($website_function, $questionnaire_id)
    {
    	if ( ! $website_function)
    	{
    		return FALSE;
    	}

    	$website_function_default = 'wf_1,wf_2,wf_3,wf_4,wf_5';

    	// Determine if the website function is set
    	$website_function_set = $this->cms_answers_model->is_website_function_set($questionnaire_id);

    	if ($website_function_set == false && $website_function == $website_function_default)
    	{
    		// Don't do initial updare with default value
    		return FALSE;
    	}

		// Update answers
		$this->cms_answers_model->save_cms_website_function($website_function, $questionnaire_id);

		return TRUE;
    }


    private function process_reference_websites($company_reference_websites, $questionnaire_id)
    {
        if ( ! $company_reference_websites)
    	{
    		return FALSE;
    	}

		// Delete reference websites
		$this->reference_websites_model->delete_missing_reference_websites($company_reference_websites, $questionnaire_id);

		// Save reference websites
		foreach($company_reference_websites as $company_reference_website)
		{
			// Only save any new reference websites
			if ($company_reference_website['id'] == 0)
			{
				$this->reference_websites_model->save_reference_website($company_reference_website, $questionnaire_id);
			}
		}

		return TRUE;
    }


    private function process_website_images($company_website_images, $questionnaire_id)
    {
        if ( ! $company_website_images)
    	{
    		return FALSE;
    	}

		// Delete website images
		$this->website_images_model->delete_missing_website_images($company_website_images, $questionnaire_id);

		// Save website images
		foreach($company_website_images as $company_website_image)
		{
			// Only save new website images
			if ($company_website_image['id'] == 0)
			{
				$this->website_images_model->save_website_image($company_website_image, $questionnaire_id);
			}
		}

		return TRUE;
    }


    private function send_completion_emails($questionnaire_id)
    {
    	$this->load->helper('email');

		// Load questionnaire details
		$questionnaire = $this->questionnaires_model->get_questionnaire($questionnaire_id);
    	$client_name = $questionnaire->client_name;
    	$issued_by_email = $questionnaire->issued_by_email;

    	// Send e-mail to client
    	$to = $questionnaire->client_email;
    	$subject = 'Questionnaire Complete - ' . $this->config->item('site_name');
    	$message = '';

    	$message .= "Dear {$client_name}," . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "Thank you for completing the online design questionnaire." . PHP_EOL;
    	$message .= "Your input will help us to design the site you require." . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "Thanks," . PHP_EOL;
    	$message .= $this->config->item('site_name');

    	send_email($to, $subject, $message);

    	// Send e-mail to admin
    	$to = $issued_by_email;
    	$subject = 'Questionnaire Complete - ' . $this->config->item('site_name');
    	$message = '';

    	$message .= "Hi," . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "Client {$client_name} has completed the online design questionnaire." . PHP_EOL;
    	$message .= PHP_EOL;
    	$message .= "Thanks," . PHP_EOL;
    	$message .= $this->config->item('site_name');

    	send_email($to, $subject, $message);
    }


    public function index($personalized_slug = 0)
    {
    	if ($this->session->userdata('personalized_slug'))
    	{
    		$last_personalized_slug = $this->session->userdata('personalized_slug');

    		if ($personalized_slug != 0 && $personalized_slug != $last_personalized_slug)
    		{
    			// Update the session
    			$this->session->set_userdata('personalized_slug', $personalized_slug);
    		}
    		else
    		{
    			$personalized_slug = $last_personalized_slug;
    		}
    	}

    	if ( ! $personalized_slug)
    	{
    		show_404();
    	}

        $data = array();

        $this->load->model('questionnaires_model');
        $questionnaire = $this->questionnaires_model->get_questionnaire_progress($personalized_slug);

        if ( ! $questionnaire)
        {
        	show_404();
        }

        $data['client_name'] = $questionnaire->client_name;
        $data['progress'] = $questionnaire->progress;

        if ($questionnaire->progress > 70)
        {
        	$data['bar_color'] = 'progress-bar-success';
        }
        elseif ($questionnaire->progress < 30)
        {
        	$data['bar_color'] = 'progress-bar-danger';
        }
        else
        {
        	$data['bar_color'] = 'progress-bar-warning';
        }

        // store the questionnaire details in the session
		$this->session->set_userdata(array(
			'questionnaire_id' => $questionnaire->questionnaire_id,
			'personalized_slug' => $personalized_slug,
			'client_id' => $questionnaire->client_id
		));

		// Check for any previous message
		if ($this->session->flashdata('message_content'))
        {
        	$data['severity'] = ($this->session->flashdata('message_severity')) ? $this->session->flashdata('message_severity') : 'info';
        	$data['message'] = $this->session->flashdata('message_content');
        }

		// General script
		$this->layout->add_script('/assets/js/questions.js');

        // Load the view
        $this->layout->set_page_title('Website Design Questionnaire');
        $this->layout->view('questions/home', $data);
    }


    public function cms()
    {
    	$questionnaire_id = $this->session->userdata('questionnaire_id');

        if ( ! $questionnaire_id)
    	{
    		show_404();
    	}

		// Load the rules arrays
		$this->config->load('form_validation');
		$cms_rules = $this->config->item('cms_rules');
		$key_services_rules = $this->config->item('key_services_rules');
		$reference_websites_rules = $this->config->item('reference_websites_rules');
		$website_images_rules = $this->config->item('website_images_rules');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		// Create additional validation rules from the key services rules
		foreach($key_services_rules as $key_services_rule)
		{
			$field_name_template = $key_services_rule['field'];
			$field_name = str_replace('%d', '', $field_name_template);

			// Skip the descriptive label which will not have a field name set
			if ($field_name_template)
			{
				$this->form_validation->set_rules($field_name, $key_services_rule['label'], $key_services_rule['rules']);
			}
		}

    	// Create additional validation rules from the reference websites rules
		foreach($reference_websites_rules as $reference_websites_rule)
		{
			$field_name_template = $reference_websites_rule['field'];
			$field_name = str_replace('%d', '', $field_name_template);

			// Skip the descriptive label which will not have a field name set
			if ($field_name_template)
			{
				$this->form_validation->set_rules($field_name, $reference_websites_rule['label'], $reference_websites_rule['rules']);
			}
		}

        // Create additional validation rules from the website images rules
		foreach($website_images_rules as $website_images_rule)
		{
			$field_name_template = $website_images_rule['field'];
			$field_name = str_replace('%d', '', $field_name_template);

			// Skip the descriptive label which will not have a field name set
			if ($field_name_template)
			{
				$this->form_validation->set_rules($field_name, $website_images_rule['label'], $website_images_rule['rules']);
			}
		}

		// Main CMS Validation
		if ($this->form_validation->run('cms_rules') == TRUE)
		{
			$this->load->helper('array');

			$blank_elements = 0;
			$total_elements = 0;

			/* Process the answers for Key Services */
			$processed = $this->process_key_services($this->input->post('company_key_services'), $questionnaire_id);
			$blank_elements += ($processed) ? 0 : 1;
			$total_elements ++;

			/* Process the answers for Website Function */
			$processed = $this->process_website_function($this->input->post('website_function'), $questionnaire_id);
			$blank_elements += ($processed) ? 0 : 1;
			$total_elements ++;

			/* Process the answers for Reference Websites */
			$processed = $this->process_reference_websites($this->input->post('company_reference_websites'), $questionnaire_id);
			$blank_elements += ($processed) ? 0 : 1;
			$total_elements ++;

			/* Process the answers for Website Images */
			$processed = $this->process_website_images($this->input->post('company_website_images'), $questionnaire_id);
			$blank_elements += ($processed) ? 0 : 1;
			$total_elements ++;

			$form_data = $this->input->post();
			unset($form_data['website_function']);

			// Process CMS Answers
			foreach ($form_data as $form_element => $form_element_value)
			{
				// Append array brackets to names of arrays
				if (is_array($form_data[$form_element]))
				{
					$form_element_name = "{$form_element}[]";
				}
				else
				{
					$form_element_name = $form_element;
				}

				// Remove any form elements that are not CMS form elements
				if ( ! in_array_r($form_element_name, $cms_rules))
				{
					unset($form_data[$form_element]);
					continue;
				}

				// Remove any 'other' elements if empty or where the parent element is not set
				if (substr($form_element, -6) == '_other')
				{
					$parent_element = substr($form_element, 0, -6);

					if (empty($form_element_value) || array_key_exists($parent_element, $form_data) === false)
					{
						unset($form_data[$form_element]);
						continue;
					}
				}

				// Remove the 'IE Version' element if empty or where the parent element is not set
				if ($form_element == 'your_browser_ie')
				{
					if (empty($form_element_value) || array_key_exists('your_browser', $form_data) === false)
					{
						unset($form_data[$form_element]);
						continue;
					}
				}

				// Set any empty values to NULL
				if (empty($form_element_value))
				{
					$form_data[$form_element] = null;
				}
			}

			// Save CMS Answers to database
			$progress = $this->cms_answers_model->save_cms_answers($questionnaire_id, $form_data, $blank_elements, $total_elements);

			$this->load->model('questionnaires_model');
			$this->questionnaires_model->set_questionnaire_progress($questionnaire_id, $progress);

			// Update client last activity
			$client_id = $this->session->userdata('client_id');

			$this->load->model('clients_model');
			$this->clients_model->update_client_last_activity($client_id);

			// If the progress is 100%, e-mail the client and the issuer that the questionnaire is complete
			if ($progress == 100)
			{
				$this->send_completion_emails($questionnaire_id);
			}

			// Set success message and return to admin home
			$this->session->set_flashdata('message_severity', 'success');
			$this->session->set_flashdata('message_content', "<strong>Success!</strong> Answers successfully saved.");

			redirect('questions');
			exit;
		}

        $data = array();

        // Load form constants
        $data['website_look_options'] = unserialize(WEBSITE_LOOK_OPTIONS);
        $data['website_elements'] = unserialize(WEBSITE_ELEMENTS);
        $data['website_social_media'] = unserialize(WEBSITE_SOCIAL_MEDIA);
        $data['os_platform'] = unserialize(OS_PLATFORM);
        $data['mobile_os_platform'] = unserialize(MOBILE_OS_PLATFORM);
        $data['web_browsers'] = unserialize(WEB_BROWSERS);

        // Get the form labels from the rules array
        $data['cms_rules'] = $cms_rules;
        $data['key_services_rules'] = $key_services_rules;
        $data['reference_websites_rules'] = $reference_websites_rules;
        $data['website_images_rules'] = $website_images_rules;

        // Load any previous answers
        $data['cms'] = $this->cms_answers_model->load_cms_answers($questionnaire_id);
        $data['key_services'] = $this->key_services_model->load_key_services($questionnaire_id);
        $data['reference_websites'] = $this->reference_websites_model->load_reference_websites($questionnaire_id);
        $data['website_images'] = $this->website_images_model->load_website_images($questionnaire_id);

        // Set body attributes
        $this->layout->set_body_attributes('class="cms-questions" data-spy="scroll" data-target="#side-nav"');

		// Font Awesome CDN
		$this->layout->add_stylesheet('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');

		// Load jQuery UI resources
		$this->layout->add_script('/assets/js/validator/validator.min.js');

		// Load JavaScript Bootstrap Validator resources
		$this->layout->add_stylesheet('/assets/css/jquery-ui/jquery-ui.min.css');
		$this->layout->add_script('/assets/js/jquery-ui/jquery-ui.min.js');

		// Bigstock API
		$this->layout->add_stylesheet('/assets/css/bigstock-api/bigstock-api.css');
		$this->layout->add_script('/assets/js/bigstock-api/bigstock-api.js');

		// General CMS Questionnaire style and script
		$this->layout->add_stylesheet('/assets/css/cms-questions.css');
		$this->layout->add_script('/assets/js/cms-questions.js');

        // Load the view
        $this->layout->set_page_title('Website Design Questionnaire');
        $this->layout->view('questions/cms', $data);
    }


    public function complete()
    {
    	$questionnaire_id = $this->session->userdata('questionnaire_id');

        if ( ! $questionnaire_id)
    	{
    		show_404();
    	}

    	$this->load->model('questionnaires_model');

    	// The client has chosen to complete the questionnaire.
		$this->questionnaires_model->set_questionnaire_progress($questionnaire_id, 100);

		// E-mail the client and the issuer that the questionnaire is complete
		$this->send_completion_emails($questionnaire_id);

    	// Return
		redirect('/questions');
    }

}

// END Questions class

/* End of file questions.php */
/* Location: ./application/controllers/questions.php */