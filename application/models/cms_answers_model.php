<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cms Answers model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Cms_answers_model extends CI_Model
{
	private $website_function_delimiter = ',';
	private $comma_seperated = ', ';


 	public function __construct()
    {
        parent::__construct();

		// The Table Class will auto-generate HTML tables from database result sets
		$this->load->library('table');
    }


    private function create_cms_answers($questionnaire_id)
    {
		// Define the query
        $this->db->set('questionnaire_id', $questionnaire_id);

		// Run the query
		$this->db->insert('cms_answers');

		$id = $this->db->insert_id();

		// Define the query
		$this->db->from('cms_answers');
		$this->db->where('id', $id);

		// Run the query
        $query = $this->db->get();

        // Return the query
        return $query;
    }


    private function get_serialized_answers()
    {
    	$serialized_answers = array();

		// Load the validation rules array
		$this->config->load('form_validation');
		$cms_rules = $this->config->item('cms_rules');

		foreach($cms_rules as $cms_rule)
		{
			$field_name = $cms_rule['field'];

			// Serialised rules end with empty square brackets
			if (substr($field_name, -2) == '[]')
			{
				// Remove the brackets and add the field name
				$serialized_answers[] = substr($field_name, 0, -2);
			}
		}

		return $serialized_answers;
    }


	private function get_questionnaire_progress($questionnaire_id, $running_blank, $running_total)
	{
		// Any additional questions that have been counted are taken into account here
		$blank = $running_blank;
		$total = $running_total;

		// Do not count any record IDs. The 'website_function' field is counted elsewhere
		$unwanted_fields = array('id', 'questionnaire_id', 'website_function');

		// Define the query
		$this->db->from('cms_answers');
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() != 1)
		{
		   return FALSE;
		}

		foreach($query->row() as $field => $value)
		{
			// Skip unwanted fields
			if (in_array($field, $unwanted_fields))
			{
				continue;
			}

			// Count blanks answers
			if (is_null($value))
			{
				$blank++;
			}

			// Count the total number of answers
			$total++;
		}

		// Determine the percentage progress, rounded down to the next lowest integer value
		$progress = floor((($total - $blank) / $total) * 100);

		return $progress;
	}


    private function get_question_label($cms_question)
    {
    	$this->load->helper('array');

		$this->config->load('form_validation');
		$cms_rules = $this->config->item('cms_rules');

		$key = recursive_array_search($cms_question, $cms_rules);

		if ($key === FALSE)
		{
			// Try a second time, looking for an array
			$key = recursive_array_search("{$cms_question}[]", $cms_rules);

			if ($key === FALSE)
			{
				return 'Undefined';
			}
		}

    	return $cms_rules[$key]['label'];
    }


    private function get_answer_label($question, $answers)
    {
		switch ($question)
		{
			case 'website_look':
				$lookup = unserialize(WEBSITE_LOOK_OPTIONS);
				break;

			case 'website_elements':
				$lookup = unserialize(WEBSITE_ELEMENTS);
				break;

			case 'website_social_media':
				$lookup = unserialize(WEBSITE_SOCIAL_MEDIA);
				break;

			case 'your_operating_system_platform':
				$lookup = unserialize(OS_PLATFORM);
				break;

			case 'your_mobile_operating_system_platform':
				$lookup = unserialize(MOBILE_OS_PLATFORM);
				break;

			case 'your_browser':
				$lookup = unserialize(WEB_BROWSERS);
				break;

			default:
				$lookup = array();
				break;
		}

		if ($lookup)
		{
			foreach($answers as $key => $answer)
	    	{
	    		if (isset($lookup[$answer]))
	    		{
	    			$answers[$key] = $lookup[$answer];
	    		}
	    	}
		}

    	return $answers;
    }

    private function get_website_function_name($website_function_array)
    {
    	return $website_function_array['name'];
    }


    private function extract_other_field($answer_array, $other_value)
    {
    	// Find the key with the value of 'other'
    	$other_key = array_search('other', $answer_array);

    	if ($other_key !== FALSE)
    	{
	    	// Set the 'other' value
	    	$answer_array[$other_key] = $other_value;
    	}

    	return $answer_array;
    }


    private function extract_ie_field($answer_array, $ie_value)
    {
    	// Find the key with the value of 'internet_explorer'
    	$ie_key = array_search('internet_explorer', $answer_array);

    	if ($ie_key !== FALSE)
    	{
	    	// Set the 'tag' value
	    	$answer_array[$ie_key] .= " {$ie_value}";
    	}

    	return $answer_array;
    }


	public function load_cms_answers($questionnaire_id)
	{
		// Define the query
		$this->db->from('cms_answers');
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() != 1)
		{
		   $query = $this->create_cms_answers($questionnaire_id);
		}

		// Load the answers
		$answers = $query->row();

		// Determine which answers are serialized
		$serialized_answers = $this->get_serialized_answers();

		// Unserialize any serialized answers
		foreach ($serialized_answers as $field_name)
		{
			if (is_null($answers->{$field_name}))
			{
				$answers->{$field_name} = array();
			}
			else
			{
				$answers->{$field_name} = unserialize($answers->{$field_name});
			}

			// Load 'internet_explorer_version' field value
			if ($field_name == 'your_browser')
			{
				$answers->your_browser_ie = '';

				if (array_key_exists('internet_explorer_version', $answers->your_browser))
				{
					$answers->your_browser_ie = $answers->your_browser['internet_explorer_version'];
					unset($answers->your_browser['internet_explorer_version']);
				}
			}

			// Load any associated 'other' field value
			$field_name_other = "{$field_name}_other";
			$answers->{$field_name_other} = '';

			if (array_key_exists('other', $answers->{$field_name}))
			{
				$answers->{$field_name_other} = $answers->{$field_name}['other'];
				unset($answers->{$field_name}['other']);
			}
		}

		// Unserialize the website function answers
		$website_function = array();
		$website_function_options = unserialize(WEBSITE_FUNCTION_OPTIONS);

		if (is_null($answers->website_function))
		{
			foreach ($website_function_options as $website_function_key => $website_function_name)
			{
				$website_function[] = array(
					'id' => $website_function_key,
					'name' => $website_function_name
				);
			}
		}
		else
		{
			$website_function_array = explode($this->website_function_delimiter, $answers->website_function);

			foreach ($website_function_array as $website_function_key)
			{
				$website_function[] = array(
					'id' => $website_function_key,
					'name' => $website_function_options[$website_function_key]
				);
			}
		}

		$answers->website_function = $website_function;

		// Return the answers
		return $answers;
	}


	public function save_cms_answers($questionnaire_id, $form_data, $blank_elements, $total_elements)
	{
		// Clear any arrays as empty array don't get POSTed
		$serialized_answers = $this->get_serialized_answers();

		foreach($serialized_answers as $field_name)
		{
			$this->db->set($field_name, 'NULL', FALSE);
		}

		$this->db->where('questionnaire_id', $questionnaire_id);
		$this->db->update('cms_answers');

		// Serialize any arrays
		foreach($form_data as $field => $data)
		{
			if (is_array($data))
			{
				// Append the 'internet_explorer_version' field
				if ($field == 'your_browser')
				{
					if (array_key_exists('your_browser_ie', $form_data))
					{
						if (in_array('internet_explorer', $data) && $form_data['your_browser_ie'])
						{
							$data['internet_explorer_version'] = $form_data['your_browser_ie'];
						}

						unset($form_data['your_browser_ie']);
					}
				}

				// Append the 'other' field
				$other_text_field = "{$field}_other";

				if (array_key_exists($other_text_field, $form_data))
				{
					if (in_array('other', $data) && $form_data[$other_text_field])
					{
						$data['other'] = $form_data[$other_text_field];
					}

					unset($form_data[$other_text_field]);
				}

				// Serialize
				$form_data[$field] = serialize($data);
			}
		}

		// Save the form data
		$this->db->where('questionnaire_id', $questionnaire_id);
		$this->db->update('cms_answers', $form_data);

		// Return the questionnaire progress
		$progress = $this->get_questionnaire_progress($questionnaire_id, $blank_elements, $total_elements);

		return $progress;
	}


	public function is_website_function_set($questionnaire_id)
	{
		// Define the query
		$this->db->select('website_function');
		$this->db->from('cms_answers');
		$this->db->where('questionnaire_id', $questionnaire_id);

		// Run the query
        $query = $this->db->get();

		if ($query->num_rows() != 1)
		{
		   return false;
		}

		$row = $query->row();

		// Check if the website function has a value defined
		if (is_null($row->website_function))
		{
			return false;
		}

		return true;
	}


	public function save_cms_website_function($website_function, $questionnaire_id)
	{
		// Save the form data
		$this->db->set('website_function', $website_function);
		$this->db->where('questionnaire_id', $questionnaire_id);
		$this->db->update('cms_answers');

		// Return the number of updated fields
		return $this->db->affected_rows();
	}


    public function format_cms_answers($cms_answers)
    {
    	// Format the answers
		foreach($cms_answers as $cms_question => $cms_answer)
    	{
    		switch ($cms_question)
    		{
    			case 'id':
    			case 'questionnaire_id':
    				unset($cms_answers->$cms_question);
    				break;

    			case 'website_function':
    				$website_function_names = array_map(array($this, 'get_website_function_name'), $cms_answer);
        			$cms_answers->$cms_question = implode($this->comma_seperated, $website_function_names);
        			break;

        		case 'website_look':
    			case 'website_elements':
    			case 'website_social_media':
				case 'your_operating_system_platform':
				case 'your_mobile_operating_system_platform':
				case 'your_browser':
    				$field_name_other = "{$cms_question}_other";
    				$field_name_ie = "{$cms_question}_ie";

    				if (isset($cms_answers->{$field_name_other}))
    				{
    					$cms_answer = $this->extract_other_field($cms_answer, $cms_answers->{$field_name_other});
    					unset($cms_answers->{$field_name_other});
    				}

    		    	// your_browser_ie
    				if ($cms_question == 'your_browser' && isset($cms_answers->{$field_name_ie}))
    				{
    					$cms_answer = $this->extract_ie_field($cms_answer, $cms_answers->{$field_name_ie});
    					unset($cms_answers->{$field_name_ie});
    				}

    				$cms_answers->$cms_question = implode($this->comma_seperated, $this->get_answer_label($cms_question, $cms_answer));
        			break;

        		default:
        			break;
			}
    	}

    	// Format the questions
    	$formatted_cms_answers = array();

    	foreach($cms_answers as $cms_question => $cms_answer)
    	{
    		$cms_question_label = $this->get_question_label($cms_question);
    		$formatted_cms_answers[$cms_question_label] = $cms_answer;
    	}

    	return $formatted_cms_answers;
    }

}

// END Cms_answers_model class

/* End of file cms_answers_model.php */
/* Location: ./application/models/cms_answers_model.php */