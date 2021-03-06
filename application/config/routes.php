<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//Students API
$route['Api/getStudents'] = 'Students/getAllStudents';
$route['Api/getUnsubscribers'] = 'Students/getUnsubscribers';
$route['Api/getStudents/(:num)'] = 'Students/getStudents/$1';
$route['Api/playersubscribe/(:num)'] = 'Students/playersubscribe/$1';
$route['Api/activatePlayer/(:num)'] = 'Students/activatePlayer/$1';
$route['Api/deactivatePlayer/(:num)'] = 'Students/deactivatePlayer/$1';
$route['Api/getStudent/(:num)'] = 'Students/getStudent/$1';
$route['Api/addStudent']          = 'Students/addStudent';
$route['Api/editStudent/(:num)'] = 'Students/editStudent/$1';


//Classes API
$route['Api/getClasses']        = 'Classes/getClasses';
$route['Api/getClass/(:num)']        = 'Classes/getClass_byID/$1';
$route['Api/editClass/(:num)']        = 'Classes/editClass/$1';
$route['Api/getClassesRoutes']  = 'Classes/getRoutes';
$route['Api/addClass']          = 'Classes/addClass';
$route['Api/getAttendance/(:num)']        = 'Classes/getAttendance/$1';
$route['Api/getAttendanceforStudent/(:num)']        = 'Classes/getAttendanceforStudent/$1';
$route['Api/getSessionsForAttendance/(:num)']        = 'Classes/getSessionsForAttendance/$1';

//Positions API
$route['Api/getPositions']        = 'Positions/getPositions';
$route['Api/getPosition/(:num)']        = 'Positions/getPosition/$1';

//Users API
$route['Api/getUsers']        = 'Users/getUsers';
$route['Api/login']        = 'Users/authenticate';

//charts
$route['Api/getChart/(:num)/(:num)/(:num)'] = 'Sessions/getChart/$1/$2/$3';
$route['Api/getClassChart/(:num)/(:num)/(:num)'] = 'Classes/getClassChart/$1/$2/$3';

//Sessions API
$route['Api/getAllSessions'] = 'Sessions/getAllSessions';
$route['Api/getSessions/(:num)'] = 'Sessions/getSessions/$1';
$route['Api/getSession/(:num)'] = 'Sessions/getSession/$1';
$route['Api/takeAttendance/(:any)'] = 'Sessions/takeAttendance/$1';
$route['Api/getSession_limit/(:num)'] = 'Sessions/getSession_CalendarEvent/$1';
$route['Api/addSession']          = 'Sessions/addSession';
$route['Api/editSession/(:num)'] = 'Sessions/editSession/$1';
$route['Api/deleteSession/(:num)'] = 'Sessions/deleteSession/$1';

//Attendance List
$route['Api/getattendancelist/(:num)'] = 'Sessions/getAttendanceList/$1';
$route['Api/setattendancetrue/(:num)/(:num)'] = 'Sessions/TakeAttendancefromTable/$1/$2';
$route['Api/setattendancefalse/(:num)/(:num)'] = 'Sessions/CancelAttendancefromTable/$1/$2';

//Payments URL
$route['Api/getClassPayments/(:num)'] = 'Payments/getPaymentsByClass/$1';
$route['Api/payPayment/(:num)'] = 'Payments/payPayment/$1';
$route['Api/getStudentsPayments/(:num)'] = 'Payments/getStudentPaymentHistory/$1';
$route['Api/insertPayment'] = 'Payments/insertPayment';

//settings URLs
$route['Api/getsettings'] = 'Payments/getSettings';
$route['Api/setsettings'] = 'Payments/setSettings';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
