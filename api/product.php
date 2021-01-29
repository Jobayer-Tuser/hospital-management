<?php

/*
| -------------------------------------------------------------------
| Read A Single Product Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "id" is existed and "status" 
| is "Active". If both condition is true the return an data array 
| object.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
| 1. Required Configuration Controller
| 2. Object Instantiate (for this API)
| 3. Execute Try and Catch Block
| 4. Flash Notification Based on Condition
*/

include("./../config/RestApiController.php");
$read = new ReadController;


try {
	if (!empty($_REQUEST['api_key'])) {
		if ($_REQUEST['api_key'] === authenticate) {
			if (!empty($id)) {
				$fetchService = $read->findOn('products', 'status', '"Active"', 'id', $id);
				if (!empty($fetchService) && is_array($fetchService)) {
					echo json_encode($fetchService, JSON_PRETTY_PRINT);
				} else {
					echo $flashMessage('Oops! no records found', false);
				}
			} else {
				echo $flashMessage('Oops! something went wrong', false);
			}
		} else {
			echo $flashMessage('Oops! invalid access code', false);
		}
	} else {
		throw new Exception($flashMessage('Authenticate access denied', false));
	}
} catch (Exception $e) {
	echo $e->getMessage();
	return false;
}

?>