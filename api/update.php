<?php

/*
| -------------------------------------------------------------------
| Update A User Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Update Query and return an data array object.
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
$read = new ReadController;
$update = new UpdateController;


try {
	if (!empty($_REQUEST['api_key'])) {
		if ($_REQUEST['api_key'] === authenticate) {
			if (!empty($id)) {
				if (!empty(@$data['name']) || @$data['mobile'] || @$data['email']) {
					$getUserDetails = $read->findOn('users', 'id', $id);

					$name = (!empty($data['name']) ? $data['name'] : $getUserDetails[0]['full_name']);
					$mobile = (!empty($data['mobile']) ? $data['mobile'] : $getUserDetails[0]['mobile']);
					$email = (!empty($data['email']) ? $data['email'] : $getUserDetails[0]['email']);

					$updateUserInfo = $update->updateUserExc($name, $mobile, $email, $id);

					if (!empty($updateUserInfo)) {
						echo $flashMessage('Congratulation, profile is updated successfully', true);
					}
				} else {
					echo $flashMessage('Oops! unable to update profile', false);
				}
			} else {
				echo $flashMessage('Oops! something went wrong', false);
			}
		} else {
			echo $flashMessage('Oops! credential is not match', false);
		}
	} else {
		throw new Exception($flashMessage('Authenticate access denied', false));
	}
} catch (Exception $e) {
	echo $e->getMessage();
	return false;
}
