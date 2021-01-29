<?php

/*
| -------------------------------------------------------------------
| Read All Comments Data
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Read Query if "status" is "Published" and 
| return an data array object.
|
| Note: Here, also assign some empty arrays to strip slashes form data
| string and return as well as an array object.
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
			$fetchComments = $read->findOn('comments', 'status', '"Published"');
			if (!empty($fetchComments)) {
				$keys = [];
				$values = [];

				foreach ($fetchComments as $index => $each) {
					foreach ($each as $key => $value) {
						array_push($keys, $key);
						array_push($values, stripslashes($value));
					}
				}

				$keys = array_chunk($keys, 6);
				$values = array_chunk($values, 6);
				$allComments = [];

				if (is_array($keys) && is_array($values)) {
					for ($i = 0; $i < count($keys); $i++) {
						$arrayCombine = array_combine($keys[$i], $values[$i]);
						array_push($allComments, $arrayCombine);
					}
				}

				echo json_encode($allComments, JSON_PRETTY_PRINT);
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
