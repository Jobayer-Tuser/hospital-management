<?php

/*
| -------------------------------------------------------------------
| Read A Single Category Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "id" is existed and "status" 
| is "active". If both condition is true then return an data array 
| object.
|
| Note: For images, also include file path and merge into arrays..
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
				$fetchCategory = $read->findOn('categories', 'status', '"Active"', 'id', $id);
				if (!empty($fetchCategory) && is_array($fetchCategory)) {
					$filePath = array('path' => $GLOBALS['CATEGORY_DIR'] . $fetchCategory[0]['logo']);
					$categoryDetails[] = array_merge_recursive($fetchCategory[0], $filePath);
					if (!empty($categoryDetails) && is_array($categoryDetails)) {
						echo json_encode($categoryDetails, JSON_PRETTY_PRINT);
					}
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
