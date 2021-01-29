<?php

/*
| -------------------------------------------------------------------
| Read All Categories Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "status" is "active" and return 
| an data array object.
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
			$fetchCategories = $read->findOn('categories', 'status', '"Active"');
			if (!empty($fetchCategories) && is_array($fetchCategories)) {
				$filePath = [];
				for ($i = 0; $i < count($fetchCategories); $i++) {
					array_push($filePath, array('path' => $GLOBALS['CATEGORY_DIR'] . $fetchCategories[$i]['logo']));
					$categoryDetails[] = array_merge_recursive($fetchCategories[$i], $filePath[$i]);
				}
				if (!empty($categoryDetails) && is_array($categoryDetails)) {
					echo json_encode($categoryDetails, JSON_PRETTY_PRINT);
				}
			} else {
				echo $flashMessage('Oops! no records found', false);
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
