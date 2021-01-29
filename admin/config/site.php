<?php

/**
 * Application Configurations
 * [1] Currency
 * [2] Currency Name
 * [3] Tax
 */
$GLOBALS['CURRENCY'] = "&#2547;";
$GLOBALS['CURRENCY_NAME'] = "BDT";
$GLOBALS['TAX'] = 7.5;



/**
 * Define Application Cypher Key
 * Define Application Root Path
 */
$GLOBALS['CYPHER_KEY'] = 'bismillah786';
function getFullHost()
{
	$protocol = $_SERVER['REQUEST_SCHEME'] . '://';
	$host = $_SERVER['HTTP_HOST'] . '/';
	$project = explode('/', $_SERVER['REQUEST_URI'])[1];
	return $protocol . $host . $project;
}

$GLOBALS['ROOT_APP'] = getFullHost();

$GLOBALS['ROOT_APPLICATION'] = "http://localhost/project/www.razmedicare.com/";



/**
 * Upload Files Directory
 * [1] Admins
 * [2] Category
 * [3] Doctors
 * [4] Users
 */
$GLOBALS['ADMINS_DIR'] = "public/uploads/admins/";
$GLOBALS['CATEGORY_DIR'] = "../public/uploads/category/";
$GLOBALS['DOCTORS_DIR'] = "../public/uploads/doctors/";
$GLOBALS['USERS_DIR'] = "../public/uploads/users/";
