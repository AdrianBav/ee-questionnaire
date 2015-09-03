<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Auth Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @author		Adrian Bavister
 */

// ------------------------------------------------------------------------

/**
 * Determine if a user is logged in
 *
 * Returns a bool to indicate if the User is logged in to the system.
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('is_logged_in'))
{
	function is_logged_in()
	{
		$CI =& get_instance();

		if ($CI->session->userdata('validated'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Get the ID of the logged in user
 *
 * Returns a integer of the currently logged in users id
 *
 * @access	public
 * @return	integer
 */
if ( ! function_exists('user_id'))
{
	function user_id()
	{
		$CI =& get_instance();
		$id = $CI->session->userdata('id');

		if ($id)
		{
			return $id;
		}
		else
		{
			return 0;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Get the name of the logged in user
 *
 * Returns a string of the currently logged in users name
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('user_name'))
{
	function user_name()
	{
		$CI =& get_instance();
		$name = $CI->session->userdata('name');

		if ($name)
		{
			return $name;
		}
		else
		{
			return '';
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Log out
 *
 * Clears the session of the currently logged in user
 *
 * @access	public
 * @return	void
 */
if ( ! function_exists('logout'))
{
	function logout()
	{
		$CI =& get_instance();

		$CI->session->unset_userdata('validated');
		session_destroy();
	}
}

/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */