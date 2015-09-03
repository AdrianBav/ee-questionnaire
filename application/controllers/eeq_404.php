<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Einstein's Eyes Questionnaire 404 controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 */
class Eeq_404 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}


    public function index()
    {
        $data = array();

        // Load the view
        $this->layout->set_page_title('Requested page not found.');
        $this->layout->view('eeq_404', $data);
    }

}

// END Eeq_404 class

/* End of file eeq_404.php */
/* Location: ./application/controllers/eeq_404.php */