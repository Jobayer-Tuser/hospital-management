<?php

$GLOBALS['CYPHER_KEY'] = 'bismillah786';

function getFullHost()
{
	$protocol = $_SERVER['REQUEST_SCHEME'] . '://';
	$host = $_SERVER['HTTP_HOST'] . '/';
	$project = explode('/', $_SERVER['REQUEST_URI'])[1];
	return $protocol . $host . $project;
}

$GLOBALS['ROOT_APP'] = getFullHost();

$GLOBALS['USERS_DIR'] = $GLOBALS['ROOT_APP'] . "/public/uploads/users/";
$GLOBALS['DOCTORS_DIR'] = $GLOBALS['ROOT_APP'] . "/public/uploads/doctors/";
$GLOBALS['CATEGORY_DIR'] = $GLOBALS['ROOT_APP'] . "/public/uploads/category/";
	
?>
