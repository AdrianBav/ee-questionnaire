<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// check if user is already logged in
		if (is_logged_in())
		{
			redirect('dashboard');
		}
	}


    public function index()
    {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('emailField', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('passwordField', 'Password', 'trim|required|xss_clean|callback_validate');

    	if ($this->form_validation->run() == TRUE)
		{
			// success!
			redirect('dashboard');
		}

        $data = array();

        // Load the view
        $this->layout->set_page_title('Administrator Log in');
        $this->layout->view('login', $data);
    }


 	public function validate($password)
	{
		$this->load->model('users_model');

   		// Get the email
   		// Salt and encode the password
		$email = $this->input->post('emailField');
		$password = md5($password . PASSWORD_SALT);

		// Verify the credentials
		if ($this->users_model->validate_user_credentials($email, $password))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('validate', 'Invalid email or password');
			return false;
		}
	}

}

// END Login class

/* End of file login.php */
/* Location: ./application/controllers/login.php */