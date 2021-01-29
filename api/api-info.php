<?php

/**
 * [1] Required Header
 * [2] API Resource or Base Path and Authorization Key
 * [3] Return as an Array Object
 */
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include('./../config/site.php');


$apiPath = array(
	"API"	=> array(
		"base_url"	=> $GLOBALS['ROOT_APP'] . '/api/',
		"api_key"	=> "1a4bacabfe77eb86fe0c46a1eb3cf1654c6d55531"
	)
);


if (is_array($apiPath) && !empty($apiPath)) :
	echo json_encode($apiPath, JSON_PRETTY_PRINT);
else :
	echo json_encode(array('message' => 'Oops! no records found', 'status' => false), JSON_PRETTY_PRINT);
endif;
