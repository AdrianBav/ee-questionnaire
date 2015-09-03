<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Form Validation
|--------------------------------------------------------------------------
|
| A nice feature of the Form Validation class is that it permits you to store all your validation rules for your entire application in a config file.
|
|	https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#savingtoconfig
|
| You can organize these rules into "groups".
| These groups can either be loaded automatically when a matching controller/function is called, or you can manually call each set as needed.
|
*/
$config = array(
	'cms_rules' => array(
		// [00 - 06] Section 1
		array(
			'field'   => 'company_name',
			'label'   => 'Company Trade Name',
			'help' 	  => 'Also referred to as a Fictitious Name or a Doing Business As (DBA). eg: <em>Acme</em>',
			'rules'   => 'trim|required'
		),
		array(
			'field'   => 'company_legal_name',
			'label'   => 'Company Legal Name',
			'help'	  => 'Will often have a legal ending such as LLC, Inc. or LLP. eg: <em>Acme Corporation, Inc.</em>',
			'rules'   => 'trim|required'
		),
		array(
			'field'   => 'company_slogan',
			'label'   => 'Company Slogan',
			'help'    => 'Tagline or corporate slogan. eg: <em>A company that makes everything!</em>',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_address',
			'label'   => 'Company Address',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_telephone',
			'label'   => 'Company Telephone',
			'help'	  => 'List if multiple, eg: <em>(555) 123-1111 Head Office, (555) 123-2222 Warehouse</em>',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_fax',
			'label'   => 'Company Fax',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_email',
			'label'   => 'Company E-mail',
			'help'    => 'The website will automatically forward any correspondence to this e-mail address.',
			'rules'   => 'trim|required|valid_email'
		),
		// [07 - 11] Section 2
		array(
			'field'   => 'company_function',
			'label'   => 'What does your company do?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_unique',
			'label'   => 'What makes your company unique?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_clients',
			'label'   => 'Who are your clients?',
			'help'    => 'eg: <em>government, young adults, women, people needing plumbing repairs, oil companies</em>',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_target_audience',
			'label'   => 'Who is your target audience for the website?',
			'help'    => 'eg: <em>B to B, B to C, age, income level, education level, special needs</em>',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_competitive_edge',
			'label'   => 'What is your competitive edge?',
			'help'    => 'What makes you different from your competitors?',
			'rules'   => 'trim'
		),
		// [12 - 17] Section 3
		array(
			'field'   => 'website_look[]',
			'label'   => 'What type of look are you trying to achieve?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_look_other',
			'label'   => 'Other',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_function',
			'label'   => 'What is the most important function of your website?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_colors',
			'label'   => 'What colors or color schemes would you like?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_homepage',
			'label'   => 'What would you like to highlight on the homepage?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_navigation',
			'label'   => 'Do you have specific ideas about navigation?',
			'help'    => '',
			'rules'   => 'trim'
		),
		// [18 - 20] Section 4
		array(
			'field'   => 'current_website_url',
			'label'   => 'Current Site URL',
			'help'    => '',
			'rules'   => 'trim|prep_url'
		),
		array(
			'field'   => 'current_website_likes',
			'label'   => 'What are your likes of your current site?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'current_website_dislikes',
			'label'   => 'What are your dislikes of your current site?',
			'help'    => '',
			'rules'   => 'trim'
		),
		// [21 - 26] Section 5
		array(
			'field'   => 'website_elements[]',
			'label'   => 'Please select the elements that you would like included.',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_elements_other',
			'label'   => 'Other.',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_social_media[]',
			'label'   => 'Please select the social media that you would like included.',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_social_media_other',
			'label'   => 'Other.',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_logo',
			'label'   => 'Are you interested in learning more about a new logo, or a refreshed version of your logo?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'website_images',
			'label'   => 'What type of images would you like to use on your website?',
			'help'    => '',
			'rules'   => 'trim'
		),
		// [27 - 34] Section 6
		array(
			'field'   => 'your_additional_thoughs',
			'label'   => 'Please provide any additional thoughts concerning the design of you website.',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_operating_system_platform[]',
			'label'   => 'What is your operating system platform?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_operating_system_platform_other',
			'label'   => 'Other',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_mobile_operating_system_platform[]',
			'label'   => 'What is your mobile operating system platform?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_mobile_operating_system_platform_other',
			'label'   => 'Other',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_browser[]',
			'label'   => 'What web browser do you use?',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_browser_ie',
			'label'   => 'IE Version',
			'help'    => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'your_browser_other',
			'label'   => 'Other',
			'help'    => '',
			'rules'   => 'trim'
		)
	),
	'key_services_rules' => array(
		array(
			'field'   => '',
			'label'   => 'What are your key products and/or services?',
			'rules'   => ''
		),
		array(
			'field'   => 'company_key_services[%d][id]',
			'label'   => 'Id',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_key_services[%d][service]',
			'label'   => 'Product / Service',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_key_services[%d][description]',
			'label'   => 'Description',
			'rules'   => 'trim'
		)
	),
	'reference_websites_rules' => array(
		array(
			'field'   => '',
			'label'   => 'Please list 3-5 websites, competitors and non-competitors, that you like.',
			'rules'   => ''
		),
		array(
			'field'   => 'company_reference_websites[%d][id]',
			'label'   => 'Id',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_reference_websites[%d][title]',
			'label'   => 'Title',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_reference_websites[%d][url]',
			'label'   => 'URL',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_reference_websites[%d][competitor]',
			'label'   => 'Competitor',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_reference_websites[%d][comments]',
			'label'   => 'Comments',
			'rules'   => 'trim'
		)
	),
	'website_images_rules' => array(
		array(
			'field'   => '',
			'label'   => 'What type of images would you like to use on your website?',
			'rules'   => ''
		),
		array(
			'field'   => 'company_website_images[%d][id]',
			'label'   => 'Id',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_website_images[%d][bigstock_id]',
			'label'   => 'Id',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_website_images[%d][bigstock_thumb]',
			'label'   => 'Thumb',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'company_website_images[%d][bigstock_title]',
			'label'   => 'Title',
			'rules'   => 'trim'
		)
	),
	'project_assets_rules' => array(
		array(
			'field'   => 'title',
			'label'   => 'Title',
			'help' 	  => '',
			'rules'   => 'trim|required'
		),
		array(
			'field'   => 'filename',
			'label'   => 'Filename',
			'help' 	  => '',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'comments',
			'label'   => 'Comments',
			'help' 	  => '',
			'rules'   => 'trim'
		)
	)
);
