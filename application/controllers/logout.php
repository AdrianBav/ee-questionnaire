<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logout controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Logout extends CI_Controller {

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
		logout();
		redirect('/');
    }

}

// END Logout class

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */