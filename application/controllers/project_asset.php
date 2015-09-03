<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Project_asset controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Project_asset extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('project_assets_model');
	}


    public function index()
    {
        $questionnaire_id = $this->session->userdata('questionnaire_id');

        if ( ! $questionnaire_id)
    	{
    		show_404();
    	}

        $data = array();

		// Load the rules arrays
		$this->config->load('form_validation');
		$project_assets_rules = $this->config->item('project_assets_rules');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$upload_field_name = $project_assets_rules[1]['field'];

		// Handle CI issue with required file upload fields
	    if (empty($_FILES[$upload_field_name]['name']))
		{
	    	$this->form_validation->set_rules($upload_field_name, $project_assets_rules[1]['label'], 'required');
		}

		if ($this->form_validation->run('project_assets_rules') == TRUE)
		{
			$upload_path = FCPATH . PROJECT_ASSETS_PATH . "/{$questionnaire_id}";

			// Create directory if it doesn't exist
			if ( ! is_dir($upload_path))
    		{
        		mkdir($upload_path, 0755, true);
    		}

			// Upload settings
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = PROJECT_ASSETS_ALLOWED_TYPES;
			$config['overwrite'] = PROJECT_ASSETS_OVERWRITE;
			$config['max_size']	= PROJECT_ASSETS_MAX_SIZE;
			$config['max_filename'] = PROJECT_ASSETS_MAX_FILENAME;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload($upload_field_name))
			{
				$errors = $this->upload->display_errors('<span>', '</span>');

				$data['severity'] = 'danger';
				$data['message'] = "<strong>Ooops!</strong> {$errors}";
			}
			else
			{
				$upload_data = $this->upload->data();

				$project_asset_data = array(
					'title' => $this->input->post('title'),
					'filename' => $upload_data['file_name'],
					'mimetype' => $upload_data['file_type'],
					'comments' => $this->input->post('comments')
				);

				// Save file upload details to database
				$this->project_assets_model->add_project_asset($questionnaire_id, $project_asset_data);

				$data['severity'] = 'success';
				$data['message'] = '<strong>Success!</strong> Upload OK.';

				// Redirect to itself to clear form submissions
				redirect(current_url());
			}
		}

        // Get the form labels from the rules array
        $data['project_assets_rules'] = $project_assets_rules;

        // Load any previous assets
        $this->load->model('project_assets_model');
        $data['project_assets'] = $this->project_assets_model->load_project_assets($questionnaire_id);

		// General CMS Questionnaire style and script
		$this->layout->add_stylesheet('/assets/css/cms-questions.css');
		$this->layout->add_script('/assets/js/cms-questions.js');

        // Load the view
        $this->layout->set_page_title('Project Assets');
        $this->layout->view('questions/assets', $data);
    }


    public function remove()
    {
        $questionnaire_id = $this->session->userdata('questionnaire_id');

        if ( ! $questionnaire_id)
    	{
    		show_404();
    	}

    	$upload_path = FCPATH . PROJECT_ASSETS_PATH . "/{$questionnaire_id}";

    	// Look-up the project assets filename
		$project_asset_id = $this->input->post('id');

		$project_asset = $this->project_assets_model->get_project_asset($project_asset_id);
		$filename = $project_asset->filename;

		// Delete the file from the server
		$result = unlink("{$upload_path}/{$filename}");

		$affected_rows = 0;

		if ($result)
		{
	    	// Remove the project asset from the database
			$affected_rows = $this->project_assets_model->remove_project_asset($project_asset_id);
		}

		return $affected_rows;
    }


    public function download($project_asset_id = 0)
    {
    	// user must be logged in to download a project asset
		if ( ! is_logged_in())
		{
			redirect('/');
		}

        if ( ! $project_asset_id)
    	{
    		redirect('/dashboard');
    	}

    	$project_asset = $this->project_assets_model->get_project_asset($project_asset_id);

    	if ( ! $project_asset)
    	{
    		$this->session->set_flashdata('message_severity', 'danger');
    		$this->session->set_flashdata('message_content', "<strong>Ooops!</strong> Can not find project asset!");

    		redirect('/dashboard');
    	}

    	// Define the file path of the project asset on the server
    	$filepath = FCPATH . PROJECT_ASSETS_PATH . "/{$project_asset->questionnaire_id}/{$project_asset->filename}";

    	// Check the file exists
    	if ( ! file_exists($filepath))
    	{
    		$this->session->set_flashdata('message_severity', 'danger');
    		$this->session->set_flashdata('message_content', "<strong>Ooops!</strong> File '{$project_asset->filename}' does not exist!");

    		redirect("/dashboard/q/{$project_asset->questionnaire_id}");
    	}

    	// Record the time and the user downloading the project asset
    	$this->project_assets_model->set_last_downloaded($project_asset_id);

		$data = array();

		// Set the project assets name and source data
		$data['filename'] = $project_asset->filename;
		$data['filedata'] = file_get_contents($filepath);

    	// Load the helper and view
    	$this->load->helper('download');
    	$this->load->view('dashboard/download', $data);
    }

}

// END Project_asset class

/* End of file project_asset.php */
/* Location: ./application/controllers/project_asset.php */