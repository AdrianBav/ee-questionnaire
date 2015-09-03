<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Einstein's Eyes Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Form Helper
 * @author		Adrian Bavister
 */

// ------------------------------------------------------------------------

/**
 * Form Label Tag - Overrides the CI version with the addition of the required field
 *
 * @access	public
 * @param	string	The text to appear onscreen
 * @param	string	The id the label applies to
 * @param	string	Additional attributes
 * @return	string
 */
if ( ! function_exists('form_label'))
{
	function form_label($label_text = '', $id = '', $attributes = array(), $required = false)
	{

		$label = '<label';

		if ($id != '')
		{
			$label .= " for=\"$id\"";
		}

		if (is_array($attributes) AND count($attributes) > 0)
		{
			foreach ($attributes as $key => $val)
			{
				$label .= ' '.$key.'="'.$val.'"';
			}
		}

		$required_markup = ($required) ? "<abbr title='Required field'>*</abbr>" : '';

		$label .= ">$required_markup $label_text</label>";

		return $label;
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Form Label Tag - accepts an array from the validation rules
 *
 * @access	public
 * @param	string	The text to appear onscreen
 * @param	string	The id the label applies to
 * @param	string	Additional attributes
 * @return	string
 */
if ( ! function_exists('questionnaire_form_label'))
{
	function questionnaire_form_label($rules = array(), $attributes = array())
	{
		// Extract the label parameters from the validation rules array
		$label_text = $rules['label'];
		$id = $rules['field'];
		$required = (strpos($rules['rules'], 'required') === false) ? false : true;
		$recommended = (in_array('recommended', $attributes, true)) ? true : false;

		$label = '<label';

		if ($id != '')
		{
			$label .= " for=\"$id\"";
		}

		if (is_array($attributes) AND count($attributes) > 0)
		{
			foreach ($attributes as $key => $val)
			{
				if ($key == 'recommended')
				{
					unset($key);
					continue;
				}

				$label .= ' '.$key.'="'.$val.'"';
			}
		}

		$required_markup = ($required) ? "<abbr title='Required field'>*</abbr>" : '';
		$recommended_markup = ($recommended) ? "<abbr title='Recommended field' class='recommended'>*</abbr>" : '';

		$label .= ">$required_markup $recommended_markup $label_text</label>";

		return $label;
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Help Block Tag - Block level help text for form controls.
 *
 * @access	public
 * @param	array	Array from the validation rules
 * @return	string
 */
if ( ! function_exists('questionnaire_help_block'))
{
	function questionnaire_help_block($rules)
	{
		$help_block = '';

		if (isset($rules['help']) && $rules['help'])
		{
			$help_block = '<span class="help-block">' . $rules['help'] . '</span>';
		}

		return $help_block;
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Text Input Field - accepts an array from the validation rules
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('questionnaire_form_input'))
{
	function questionnaire_form_input($type = 'text', $rules = array(), $value = '', $attributes = array(), $extra = '')
	{
		$field_name = $rules['field'];
		$id = (isset($attributes['id'])) ? $attributes['id'] : $field_name;
		$repopulate = set_value($field_name, isset($value) ? $value : '');
		$required = (strpos($rules['rules'], 'required') === false) ? '' : 'required';

		$data = array('type' => $type, 'name' => $field_name, 'value' => $repopulate, 'id' => $id);

		return "<input "._parse_form_attributes($attributes, $data).$extra.$required." />";
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Textarea field - accepts an array from the validation rules
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('questionnaire_form_textarea'))
{
	function questionnaire_form_textarea($rules = array(), $value = '', $attributes = array(), $extra = '')
	{
		$field_name = $rules['field'];
		$id = (isset($attributes['id'])) ? $attributes['id'] : $field_name;
		$repopulate = set_value($field_name, isset($value) ? $value : '');
		$required = (strpos($rules['rules'], 'required') === false) ? '' : 'required';

		$data = array('name' => $field_name, 'id' => $id, 'cols' => '40', 'rows' => '10');

		return "<textarea "._parse_form_attributes($attributes, $data).$extra.$required.">".form_prep($repopulate, $field_name)."</textarea>";
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Hidden Input Field - accepts an array from the validation rules
 *
 * Generates hidden fields.  You can pass a simple key/value string or an associative
 * array with multiple values.
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @return	string
 */
if ( ! function_exists('questionnaire_form_hidden'))
{
	function questionnaire_form_hidden($rules = array(), $value = '', $recursing = FALSE)
	{
		static $form;

		if ($recursing === FALSE)
		{
			$form = "\n";
		}

		$field_name = $rules['field'];
		$repopulate = set_value($field_name, isset($value) ? $value : '');
		$id = $field_name;

		$form .= '<input type="hidden" name="'.$field_name.'" value="'.form_prep($repopulate, $field_name).'" id="'.$id.'" />'."\n";

		return $form;
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Checkbox Field - accepts an array from the validation rules
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
if ( ! function_exists('questionnaire_form_checkbox'))
{
	function questionnaire_form_checkbox($rules = array(), $value = '', $checked = array(), $attributes = array(), $extra = '')
	{
		$field_name = $rules['field'];

		$data = array('type' => 'checkbox', 'name' => $field_name, 'value' => $value);

		if (in_array($value, $checked))
		{
			$data['checked'] = 'checked';
		}
		else
		{
			unset($data['checked']);
		}

		return "<input "._parse_form_attributes($attributes, $data).$extra." />";
	}
}

// ------------------------------------------------------------------------

/**
 * Questionnaire Radio Button - accepts an array from the validation rules
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
if ( ! function_exists('questionnaire_form_radio'))
{
	function questionnaire_form_radio($rules = array(), $value = '', $checked = FALSE, $extra = '')
	{
		$field_name = $rules['field'];

		$data = array('name' => $field_name);
		$data['type'] = 'radio';
		return form_checkbox($data, $value, $checked, $extra);
	}
}
