<?php

/*
| -------------------------------------------------------------------
| Read All Appointment Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "id" is existed and return an 
| data array object.
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
				$fetchAppointmentData = $read->findOn('appointments', 'id', $id);
				if (!empty($fetchAppointmentData)) {
					echo json_encode($fetchAppointmentData, true);
				} else {
					echo $flashMessage('Oops!, no records found', false);
				}
			} else {
				echo $flashMessage('Oops!, something went wrong', false);
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
