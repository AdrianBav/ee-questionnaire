<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Charts model
 *
 * @package		CodeIgniter
 * @subpackage	Models
 */
Class Charts_model extends CI_Model
{

 	public function __construct()
    {
        parent::__construct();
    }


    public function get_chart_data()
    {
    	// chart colors
    	$colors = array('#f7464a', '#46bfbd', '#fdb45c', '#949fb1', '#4d5360');
    	$highlights = array('#ff5a5e', '#5ad3d1', '#ffc870', '#a8b3c5', '#616774');

    	// chart settings
    	$chart1 = array(
    		array('label' => 'CMS', 'color_id' => '0'),
    		array('label' => 'E-Commerce', 'color_id' => '1')
    	);

    	$chart2 = array(
    		array('label' => 'Issued', 'color_id' => '3'),
    		array('label' => 'In Progress', 'color_id' => '2'),
    		array('label' => 'Returned', 'color_id' => '1')
    	);

    	$chart3 = array(
    		array('label' => 'No Reminders', 'color_id' => '1'),
    		array('label' => '1 Reminder', 'color_id' => '2'),
    		array('label' => '1+ Reminder', 'color_id' => '0')
    	);

    	// chart 1 data
    	$this->db->select('SUM(project_type = "CMS") AS cms_total', false);
    	$this->db->select('SUM(project_type = "ECOMMERCE") AS ecommerce_total', false);
    	$query = $this->db->get('questionnaires');
    	$chart1_data = $query->row();

    	// chart 2 data
		$this->db->select('SUM(progress = 0) AS issued', false);
		$this->db->select('SUM(progress > 0 AND progress < 100) AS in_progress', false);
		$this->db->select('SUM(progress = 100) AS returned', false);
    	$query = $this->db->get('questionnaires');
    	$chart2_data = $query->row();

    	// chart 3 data
		$this->db->select('SUM(reminders_count = 0) AS no_reminders', false);
		$this->db->select('SUM(reminders_count = 1) AS one_reminder', false);
		$this->db->select('SUM(reminders_count > 1) AS one_plus_reminders', false);

			$sub = $this->subquery->start_subquery('from');

				$sub->select('questionnaires.id AS questionnaire_id', false);
				$sub->select('COUNT(reminders.questionnaire_id) AS reminders_count', false);
				$sub->from('questionnaires');
				$sub->join('reminders', 'reminders.questionnaire_id = questionnaires.id', 'left outer');
				$sub->group_by('questionnaires.id');

			$this->subquery->end_subquery('rc');

		$query = $this->db->get();
		$chart3_data = $query->row();

    	// package chart data in array
    	$chart_data = array(
    		'chart1' => array(
    			array(
		            'value' 	=> intval($chart1_data->cms_total),
		            'color' 	=> $colors[$chart1[0]['color_id']],
		            'highlight' => $highlights[$chart1[0]['color_id']],
		            'label' 	=> $chart1[0]['label']
    			),
    			array(
		            'value' 	=> intval($chart1_data->ecommerce_total),
		            'color' 	=> $colors[$chart1[1]['color_id']],
		            'highlight' => $highlights[$chart1[1]['color_id']],
		            'label' 	=> $chart1[1]['label']
    			)
    		),
    		'chart2' => array(
    			array(
		            'value' 	=> intval($chart2_data->issued),
		            'color' 	=> $colors[$chart2[0]['color_id']],
		            'highlight' => $highlights[$chart2[0]['color_id']],
		            'label' 	=> $chart2[0]['label']
    			),
    			array(
		            'value' 	=> intval($chart2_data->in_progress),
		            'color' 	=> $colors[$chart2[1]['color_id']],
		            'highlight' => $highlights[$chart2[1]['color_id']],
		            'label' 	=> $chart2[1]['label']
       			),
    			array(
		            'value' 	=> intval($chart2_data->returned),
		            'color' 	=> $colors[$chart2[2]['color_id']],
		            'highlight' => $highlights[$chart2[2]['color_id']],
		            'label' 	=> $chart2[2]['label']
       			)
    		),
    		'chart3' => array(
    			array(
		            'value' 	=> intval($chart3_data->no_reminders),
		            'color' 	=> $colors[$chart3[0]['color_id']],
		            'highlight' => $highlights[$chart3[0]['color_id']],
		            'label' 	=> $chart3[0]['label']
       			),
    			array(
		            'value' 	=> intval($chart3_data->one_reminder),
		            'color' 	=> $colors[$chart3[1]['color_id']],
		            'highlight' => $highlights[$chart3[1]['color_id']],
		            'label' 	=> $chart3[1]['label']
       			),
    			array(
		            'value' 	=> intval($chart3_data->one_plus_reminders),
		            'color' 	=> $colors[$chart3[2]['color_id']],
		            'highlight' => $highlights[$chart3[2]['color_id']],
		            'label' 	=> $chart3[2]['label']
      			)
    		)
    	);

    	// return the chat data as an array
    	return $chart_data;
    }

}

// END Charts_model class

/* End of file charts_model.php */
/* Location: ./application/models/charts_model.php */