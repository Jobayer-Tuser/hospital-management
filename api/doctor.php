<?php

/*
| -------------------------------------------------------------------
| Read A Single Doctor Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "id" is existed and "status" 
| is "Active". If both condition is true the return an data array 
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
				$fetchDoctor = $read->findOn('doctors', 'id', $id, 'status', '"Active"');
				if (!empty($fetchDoctor)) {
					$fetchDepartment = $read->findColumnOn('departments', 'title', 'id', $fetchDoctor[0]['department_id']);
					if (is_array($fetchDoctor) === is_array($fetchDepartment)) {
						$filePath = array('path' => $GLOBALS['DOCTORS_DIR'] . $fetchDoctor[0]['avatar']);
						$doctorsDetails[] = array_merge_recursive($fetchDoctor[0], $fetchDepartment[0], $filePath);
						
						if (!empty($doctorsDetails) && is_array($doctorsDetails)) {
							echo json_encode($doctorsDetails, JSON_PRETTY_PRINT);
						}
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
