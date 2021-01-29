<?php

/*
| -------------------------------------------------------------------
| Create A New Appointment Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query to prevent duplicate entry and 
| if not existed, then create a new appointment data and return an 
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
$date = new DateController;
$create = new CreateController;
$read = new ReadController;


try {
	if (!empty($_REQUEST['api_key'])) {
		if ($_REQUEST['api_key'] === authenticate) {
			if (!empty($data['user_id']) && !empty($data['doctor_id']) && !empty($data['time']) && !empty($data['date'])) {
				$existedData = $read->isExistOnCondition('appointment_request', 'user_id', $data['user_id'], 'doctor_id', $data['doctor_id'], 'date', $date->sqlDate($data['date']));
				if ($existedData === 1) {
					echo $flashMessage('Oops!, appointment is already booked', false);
				} else {
					$createAppointment = $create->appointmentRequest($date->sqlDate($data['date']), $data['user_id'], $data['doctor_id'], $date->sqlDateTime($data['date'] . $data['time']));
					if (!empty($createAppointment)) {
						echo $flashMessage('Congratulation!, appointment is booked', true);
					} else {
						echo $flashMessage('Oops!, something went wrong', false);
					}
				}
			} else {
				echo $flashMessage('Oops!, all fields are required', false);
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
