<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pdf controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Pdf extends CI_Controller {

	private $filepath;
	private $cssPath;


	public function __construct()
	{
		parent::__construct();

		// user must be logged in to view this page
		if ( ! is_logged_in())
		{
			redirect('/');
		}

		$this->filepath = FCPATH . "downloads/pdfs/q%d.pdf";
		$this->cssPath = FCPATH . "assets/css/%s";
	}


    public function index($questionnaire_id = 0)
    {
        if ( ! $questionnaire_id)
    	{
    		redirect('/dashboard');
    	}

    	$this->load->model('pdfs_model');
    	$output_file_name = $this->pdfs_model->get_output_file_name($questionnaire_id);

    	if ( ! $output_file_name)
    	{
    		$this->session->set_flashdata('message_severity', 'danger');
    		$this->session->set_flashdata('message_content', "<strong>Ooops!</strong> Can not find PDF!");

    		redirect("/dashboard/q/{$questionnaire_id}");
    	}

    	// Define the file path of the PDF on the server
    	$filepath = sprintf($this->filepath, $questionnaire_id);

    	// Check the file exists
    	if ( ! file_exists($filepath))
    	{
    		$this->session->set_flashdata('message_severity', 'danger');
    		$this->session->set_flashdata('message_content', "<strong>Ooops!</strong> File 'q{$questionnaire_id}.pdf' does not exist!");

    		redirect("/dashboard/q/{$project_asset->questionnaire_id}");
    	}

    	// Record the time and the user downloading the PDF
    	$this->pdfs_model->set_last_downloaded($questionnaire_id);

		$data = array();

		// Set the PDFs name and source data
		$data['filename'] = $output_file_name;
		$data['filedata'] = file_get_contents($filepath);

    	// Load the helper and view
    	$this->load->helper('download');
    	$this->load->view('dashboard/download', $data);
    }


    public function generate($questionnaire_id = 0)
    {
        if ( ! $questionnaire_id)
    	{
    		redirect('/dashboard');
    	}

    	$data = array();
    	$this->load->model(array('questionnaires_model', 'cms_answers_model', 'key_services_model', 'reference_websites_model', 'website_images_model'));

        // Load Questionnaire details
        $questionnaire = $this->questionnaires_model->get_questionnaire($questionnaire_id);
        $data['questionnaire_details'] = $questionnaire;

    	// Load and format cms answers
    	$cms_answers = $this->cms_answers_model->load_cms_answers($questionnaire_id);
		$data['cms_answers'] = $this->cms_answers_model->format_cms_answers($cms_answers);

    	// Load key services
    	$data['key_services'] = $this->key_services_model->load_key_services($questionnaire_id);

    	// Load reference websites
    	$data['reference_websites'] = $this->reference_websites_model->load_reference_websites($questionnaire_id);

    	// Load website images
    	$data['website_images'] = $this->website_images_model->load_website_images($questionnaire_id);

    	// Load the view
    	$xmlString = $this->load->view('pdf/cms', $data, TRUE);

    	// Load the PrinceXML class
    	$params = array('exe_path' => $this->config->item('prince_xml_path'));
    	$this->load->library('prince', $params);

    	// Add the bootstrap stylesheet
    	$cssPath = sprintf($this->cssPath, 'bootstrap.min.css');
    	$this->prince->addStyleSheet($cssPath);

    	// Generate the PDF
    	$filepath = sprintf($this->filepath, $questionnaire_id);
    	$result = $this->prince->convert_string_to_file($xmlString, $filepath);

    	if ($result)
    	{
    		$this->session->set_flashdata('message_severity', 'success');
    		$this->session->set_flashdata('message_content', "<strong>Success!</strong> Generated PDF.");
    	}
    	else
    	{
    		$this->session->set_flashdata('message_severity', 'danger');
    		$this->session->set_flashdata('message_content', "<strong>Ooops!</strong> Can not generate PDF.");
    	}

    	redirect("/dashboard/q/{$questionnaire_id}");
    }

}

// END Pdf class

/* End of file pdf.php */
/* Location: ./application/controllers/pdf.php */