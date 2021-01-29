<?php

/**
 * Session Event Handle Based on LogOut
 * 
 * Assign a Variable for Detect Each Pages Automatically
 * Assign an Array for Restriction
 * Access Controll Based on Condition
 */
if(@$_REQUEST['exit'] == "LogOutAdmin")
{
	session_start() ;
	session_destroy() ;
	header("Location: index");
}




$pageName = basename($_SERVER['PHP_SELF']);
$restricted = [
	'dashboard', 'add-admin', 'admins', 'add-doctor', 'doctors', 'users', 'comments', 'blank-page', 
	'categories', 'departments', 'services', 'products', 'add-statement', 'expenditure-statement', 
	'income-statement', 'monthly-statement', 'add-orders', 'order-list', 'make-appointment', 'appointments'
];

if (in_array($pageName, $restricted) && empty($_SESSION['auth_log_id'])) {
	header("Location: index");
}

?>