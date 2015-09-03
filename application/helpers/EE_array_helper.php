<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Einstein's Eyes Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Array Helper
 * @author		Adrian Bavister
 */

// ------------------------------------------------------------------------

/**
 * In Array, Recursive - Checks if a value exists in an array
 *
 * @access	public
 * @param	mixed	The searched value
 * @param	array	The array
 * @param	bool	Strict
 * @return	bool
 */
if ( ! function_exists('in_array_r'))
{
	function in_array_r($needle, $haystack, $strict = false)
	{
	    foreach ($haystack as $item)
	    {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict)))
	        {
	            return true;
	        }
	    }

	    return false;
	}
}


// ------------------------------------------------------------------------

/**
 * Recursive Array Search - Searches the array for a given value and returns the corresponding key if successful
 *
 * @access	public
 * @param	mixed	The searched value
 * @param	array	The array
 * @param	bool	Strict
 * @return	bool
 */
if ( ! function_exists('recursive_array_search'))
{
	function recursive_array_search($needle, $haystack)
	{
	    foreach($haystack as $key => $value)
	    {
	        $current_key = $key;

	        if ($needle === $value OR (is_array($value) && recursive_array_search($needle, $value) !== false))
	        {
	            return $current_key;
	        }
	    }

	    return false;
	}
}
