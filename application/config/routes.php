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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/*$route['fg_pass'] = "member/fg_pass";
$route['fg_pass.html'] = "member/fg_pass";
$route['login'] = "member/admin_access";
$route['login.html'] = "member/admin_access";
$route['logout'] = "member/admin_access/logout";
$route['logout.html'] = "member/admin_access/logout";*/

$route['login'] = "member/admin_access";
$route['logout'] = "member/admin_access/logout";

$route['manage/login'] = "member/admin_access";
$route['manage/login.html'] = "member/admin_access";
$route['manage/logout'] = "member/admin_access/logout";
$route['manage/logout.html'] = "member/admin_access/logout";

//report
$route['report/A0'] = "report/reportA0/index";
$route['report/A0/xls'] = "report/reportA0/xls";
$route['report/B0'] = "report/reportB0/index";
$route['report/B0/xls'] = "report/reportB0/xls";
$route['report/B1'] = "report/reportB1/index";
$route['report/B1/pdf'] = "report/reportB1/pdf";
$route['report/B2'] = "report/reportB1/index";
$route['report/B2/pdf'] = "report/reportB1/pdf";
$route['report/B3'] = "report/reportB3/index";
$route['report/B3/pdf'] = "report/reportB3/pdf";

$route['report/F0'] = "report/reportF0/index";
$route['report/F0/xls'] = "report/reportF0/xls";



$route['report/A1'] = "report/reportA1/index";
$route['report/A1/pdf'] = "report/reportA1/pdf";

$route['report/A2'] = "report/reportA2/index";
$route['report/A2/pdf'] = "report/reportA2/pdf";
$route['report/A3'] = "report/reportA3/index";
$route['report/A3/pdf'] = "report/reportA3/pdf";
$route['report/A4'] = "report/reportA4/index";
$route['report/A4/pdf'] = "report/reportA4/pdf";

$route['report/C0'] = "report/reportC0/index";
$route['report/C0/xls'] = "report/reportC0/xls";

$route['report/C1'] = "report/reportC1/index";
$route['report/C1/pdf'] = "report/reportC1/pdf";
$route['report/C2'] = "report/reportC2/index";
$route['report/C2/pdf'] = "report/reportC2/pdf";
$route['report/C3'] = "report/reportC3/index";
$route['report/C3/pdf'] = "report/reportC3/pdf";

$route['report/D0'] = "report/reportD0/index";
$route['report/D0/xls'] = "report/reportD0/xls";
$route['report/D6'] = "report/reportD6/index";
$route['report/D6/xls'] = "report/reportD6/xls";

$route['report/D1'] = "report/reportD1/index";
$route['report/D1/pdf'] = "report/reportD1/pdf";
$route['report/D2'] = "report/reportD2/index";
$route['report/D2/pdf'] = "report/reportD2/pdf";
$route['report/D3'] = "report/reportD3/index";
$route['report/D3/pdf'] = "report/reportD3/pdf";
$route['report/D4'] = "report/reportD4/index";
$route['report/D4/pdf'] = "report/reportD4/pdf";
$route['report/D5'] = "report/reportD5/index";
$route['report/D5/pdf'] = "report/reportD5/pdf";

$route['report/E0'] = "report/reportE0/index";
$route['report/E0/xls'] = "report/reportE0/xls";
$route['report/E1'] = "report/reportE1/index";
$route['report/E1/pdf'] = "report/reportE1/pdf";
$route['report/F2'] = "report/reportF2/index";
$route['report/F2/pdf'] = "report/reportF2/pdf";

$route['report/H0'] = "report/reportH0/index";
$route['report/H0/xls'] = "report/reportH0/xls";
$route['report/G0'] = "report/reportG0/index";
$route['report/G0/xls'] = "report/reportG0/xls";
$route['report/G6'] = "report/reportG6/index";
$route['report/G6/pdf'] = "report/reportG6/pdf";
$route['report/G7'] = "report/reportG7/index";
$route['report/G7/pdf'] = "report/reportG7/pdf";
$route['report/L0'] = "report/reportL0/index";
$route['report/L0/xls'] = "report/reportL0/xls";
$route['report/L1'] = "report/reportL1/index";
$route['report/L1/xls'] = "report/reportL1/xls";


$route['report/J0'] = "report/reportJ0/index";
$route['report/J0/xls'] = "report/reportJ0/xls";
$route['report/J1'] = "report/reportJ1/index";
$route['report/J1/pdf'] = "report/reportJ1/pdf";