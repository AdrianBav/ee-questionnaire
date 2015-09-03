<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Einstein's Eyes Email Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Email Helper
 * @author		Adrian Bavister
 */

// ------------------------------------------------------------------------

/**
 * Send an email
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('send_email'))
{
	function send_email($to, $subject, $message)
	{
		$CI =& get_instance();
		$CI->load->library('email');

		$CI->email->from($CI->config->item('site_from_email'), $CI->config->item('site_from_name'));
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($message);

		if ( ! $CI->email->send())
		{
    		log_message('error', $CI->email->print_debugger());
    		return false;
		}

		return true;
	}
}
