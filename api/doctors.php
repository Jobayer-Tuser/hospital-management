<?php

/*
| -------------------------------------------------------------------
| Read All Doctors Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "status" is "Active" and 
| return an data array object.
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
			$fetchDoctors = $read->findOn('doctors', 'status', '"Active"');

			$departmentArray = [];
			foreach ($fetchDoctors as $index => $each) {
				$fetchDepartments = $read->findColumnOn('departments', 'title', 'id', $each['department_id']);
				foreach ($fetchDepartments as $value) {
					array_push($departmentArray, $value);
				}
			}

			$doctorsDetails = [];
			if (is_array($fetchDoctors) === is_array($departmentArray)) {
				for ($i = 0; $i < count($fetchDoctors); $i++) {
					$filePath = array('path' => $GLOBALS['DOCTORS_DIR'] . $fetchDoctors[$i]['avatar']);
					$arrayMerge = array_merge_recursive($fetchDoctors[$i], $departmentArray[$i], $filePath);
					array_push($doctorsDetails, $arrayMerge);
				}
			}

			if (!empty($doctorsDetails)) {
				if (is_array($doctorsDetails)) {
					echo json_encode($doctorsDetails, JSON_PRETTY_PRINT);
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
