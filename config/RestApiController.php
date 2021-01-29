<?php

//Define API Key
$hash = "1" . sha1("bismillah786_www.mediraj.com");
define('authenticate', $hash);
//1a4bacabfe77eb86fe0c46a1eb3cf1654c6d55531

//Define Required Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET PUT POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


//Include Configuration Files
include('./../admin/config/database.php');
include('site.php');


//Register ClassFiles
spl_autoload_register(function ($class) {
	if (file_exists('./../admin/app/Http/Controllers/' . $class . '.php')) {
		include('./../admin/app/Http/Controllers/' . $class . '.php');
	}
});


//Parse All Input Values From the URL
$data = json_decode(file_get_contents("php://input"), true);


//Assign Variable Based on Request Type
if (!empty($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
} elseif (!empty($data['id'])) {
	$id = $data['id'];
} else {
	$id = null;
}


//Create a Function for Return Confirmation Message
$flashMessage = function ($message, $status) {
	$jsonObject = json_encode(
		array(
			'message'	=> $message, 
			'status'		=> $status
		), JSON_PRETTY_PRINT
	);
	return $jsonObject;
};
