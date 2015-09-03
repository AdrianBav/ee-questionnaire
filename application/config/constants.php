<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Password Salt
|--------------------------------------------------------------------------
|
*/
define('PASSWORD_SALT', 'eeq');


/*
|--------------------------------------------------------------------------
| Project Assets Upload
|--------------------------------------------------------------------------
|
*/
define('PROJECT_ASSETS_PATH', 'downloads/project_assets');
define('PROJECT_ASSETS_ALLOWED_TYPES', '*');
define('PROJECT_ASSETS_OVERWRITE', TRUE);
define('PROJECT_ASSETS_MAX_SIZE', '5120');	// 5 MB
define('PROJECT_ASSETS_MAX_FILENAME', '255');


/*
|--------------------------------------------------------------------------
| Website Look Options
|--------------------------------------------------------------------------
|
*/
$website_look_options = array(
	'athletic' 			=> 'Athletic',
	'artistic' 			=> 'Artistic',
	'business' 			=> 'Business',
	'casual' 			=> 'Casual',
	'cartoon' 			=> 'Cartoon',
	'conservative' 		=> 'Conservative',
	'cutting_edge' 		=> 'Cutting Edge',
	'corporate' 		=> 'Corporate',
	'culinary'			=> 'Culinary',
	'contemporary'		=> 'Contemporary',
	'education' 		=> 'Education',
	'female_centric'	=> 'Female Centric',
	'flashy' 			=> 'Flashy',
	'glamorous' 		=> 'Glamorous',
	'health_medical'	=> 'Health (medical)',
	'high_tech'			=> 'High-Tech',
	'industrial' 		=> 'Industrial',
	'kid_centric' 		=> 'Kid Centric',
	'legal' 			=> 'Legal',
	'male_centric' 		=> 'Male Centric',
	'minimalist' 		=> 'Minimalist',
	'nature' 			=> 'Nature',
	'personal' 			=> 'Personal',
	'luxurious' 		=> 'Luxurious',
	'formal' 			=> 'Formal',
	'professional' 		=> 'Professional',
	'relaxing' 			=> 'Relaxing',
	'urban' 			=> 'Urban',
	'playful' 			=> 'Playful',
	'warm' 				=> 'Warm',
	'tradition' 		=> 'Tradition',
	'victorian' 		=> 'Victorian',
	'other' 			=> 'Other'
);
define('WEBSITE_LOOK_OPTIONS', serialize($website_look_options));

/*
|--------------------------------------------------------------------------
| Website Function Options
|--------------------------------------------------------------------------
|
*/
$website_function_options = array(
	'wf_1'				=> 'Building a community',
	'wf_2' 				=> 'Communicating an idea',
	'wf_3' 				=> 'Visual appeal',
	'wf_4' 				=> 'Promoting sales',
	'wf_5' 				=> 'Providing information'
);
define('WEBSITE_FUNCTION_OPTIONS', serialize($website_function_options));

/*
|--------------------------------------------------------------------------
| Website Elements
|--------------------------------------------------------------------------
|
*/
$website_elements = array(
	'company_address' 	=> 'Company Address',
	'location_map' 		=> 'Location Map',
	'phone_number' 		=> 'Phone Number',
	'fax_number' 		=> 'Fax Number',
	'video_content' 	=> 'Video Content',
	'newsletter_signup' => 'Newsletter Sign-up',
	'client_login' 		=> 'Client Log in',
	'site_search' 		=> 'Site Search',
	'responsive_design' => 'Responsive Design',
	'blog_news_feed' 	=> 'Blog/News Feed',
	'mini_contact_form' => 'Mini Contact Form',
	'site_map' 			=> 'Site Map',
	'other' 			=> 'Other'
);
define('WEBSITE_ELEMENTS', serialize($website_elements));

/*
|--------------------------------------------------------------------------
| Website Social Media
|--------------------------------------------------------------------------
|
*/
$website_social_media = array(
	'facebook' 			=> 'Facebook',
	'twitter' 			=> 'Twitter',
	'linkedin' 			=> 'Linked In',
	'pinterest' 		=> 'Pinterest',
	'google-plus' 		=> 'Google+',
	'tumblr' 			=> 'Tumblr',
	'instagram' 		=> 'Instagram',
	'flickr'			=> 'Flickr',
	'other' 			=> 'Other'
);
define('WEBSITE_SOCIAL_MEDIA', serialize($website_social_media));

/*
|--------------------------------------------------------------------------
| Operating System Platforms
|--------------------------------------------------------------------------
|
*/
$os_platform = array(
	'windows' 			=> 'Windows',
	'apple' 			=> 'Mac',
	'linux' 			=> 'Linux',
	'other' 			=> 'Other'
);
define('OS_PLATFORM', serialize($os_platform));

/*
|--------------------------------------------------------------------------
| Mobile Operating System Platforms
|--------------------------------------------------------------------------
|
*/
$mobile_os_platform = array(
	'apple'				=> 'iOS',
	'android' 			=> 'Android',
	'windows' 			=> 'Windows',
	'other' 			=> 'Other'
);
define('MOBILE_OS_PLATFORM', serialize($mobile_os_platform));

/*
|--------------------------------------------------------------------------
| Web Browsers
|--------------------------------------------------------------------------
|
*/
$web_browsers = array(
	'google_chrome' 	=> 'Google Chrome',
	'mozilla_firefox' 	=> 'Mozilla Firefox',
	'internet_explorer' => 'Internet Explorer',
	'apple_safari' 		=> 'Apple Safari',
	'opera' 			=> 'Opera',
	'other' 			=> 'Other'
);
define('WEB_BROWSERS', serialize($web_browsers));


/* End of file constants.php */
/* Location: ./application/config/constants.php */