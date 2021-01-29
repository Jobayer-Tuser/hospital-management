<?php

/*
| -------------------------------------------------------------------
| Create A New User Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Create Query and return an data array object.
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
$misc = new MiscellaneousController;
$create = new CreateController;
$read = new ReadController;


try {
	if (!empty($_REQUEST['api_key'])) {
		if ($_REQUEST['api_key'] === authenticate) {
			if (!empty($data['name']) && !empty($data['mobile']) && !empty($data['email']) && !empty($data['password'])) {
				$createUser = $create->addUser($data['name'], $data['mobile'], $data['email'], $data['password']);
				if (!empty($createUser)) {
					echo $flashMessage('Data is created successfully', true);
				} else {
					echo $flashMessage('Oops!, might be some data is already exist', false);
				}
			} else {
				echo $flashMessage('Oops!, all fields are required', false);
			}
		} else {
			echo $flashMessage('Oops!, invalid access code', false);
		}
	} else {
		throw new Exception($flashMessage('Authenticate access denied', false));
	}
} catch (Exception $e) {
	echo $e->getMessage();
	return false;
}
