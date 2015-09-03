<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// customer questionnaire home
$route['go/(:any)'] = 'questions/index/$1';

// customer start or resume questionnaire
$route['questions/cms'] = 'questions/cms';

// customer add project assets
$route['go/assets'] = 'project_asset';

// admin view questionnaire
$route['dashboard/q/(:num)'] = 'questionnaire/index/$1';
$route['dashboard/q'] = 'dashboard';

// admin download answers pdf
$route['pdf/(:num)'] = 'pdf/index/$1';
$route['pdf'] = 'dashboard';

// admin download project asset
$route['dashboard/pa/(:num)'] = 'project_asset/download/$1';
$route['dashboard/pa'] = 'dashboard';

// admin
$route['dashboard/issue'] = 'issue';
$route['dashboard/logout'] = 'logout';
$route['dashboard/(:any)'] = 'dashboard/$1';
$route['dashboard'] = 'dashboard';

// reserved routes
$route['default_controller'] = 'login';
$route['404_override'] = 'eeq_404';


/* End of file routes.php */
/* Location: ./application/config/routes.php */