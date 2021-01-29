<?php

/*
| -------------------------------------------------------------------
| Create A New Comment Data
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


try {
	if (!empty($_REQUEST['api_key'])) {
		if ($_REQUEST['api_key'] === authenticate) {
			if (!empty($data['user_id']) && !empty($data['comment'])) {
				$addComments = $create->addComments($data['user_id'], $data['comment']);
				if (!empty($addComments)) {
					echo $flashMessage('Thanks for your valuable comment', true);
				} else {
					echo $flashMessage('Oops! something went wrong', false);
				}
			} else {
				echo $flashMessage('Oops! all fields are required', false);
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
