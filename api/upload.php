<?php

/*
| -------------------------------------------------------------------
| Upload User Image
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

header('Content-Type: multipart/form-data');
include("./../config/RestApiController.php");

$misc = new MiscellaneousController;
$read = new ReadController;
$update = new UpdateController;

$uploadDir = "./../public/uploads/users/";


try {
	if (!empty($_REQUEST['api_key'])) {
		if ($_REQUEST['api_key'] === authenticate) {
			if (!empty($id)) {
				$getUserDetails = $read->findOn('users', 'id', $id);
				if (is_uploaded_file(@$_FILES['avatar']['tmp_name'])) {
					$userAvatar = date("YmdHis") . "_" . $_FILES['avatar']['name'];
					$fileValidation = $misc->checkImage($_FILES['avatar']['type'], $_FILES['avatar']['size'], $_FILES['avatar']['error']);

					if ($fileValidation === 1) {
						$updateUserInfo = $update->updateUserInc($userAvatar, $id);
						if ($updateUserInfo > 0) {
							move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $userAvatar);
							if (!is_null($getUserDetails[0]['avatar']) && file_exists($uploadDir . $getUserDetails[0]['avatar'])) {
								unlink($uploadDir . $getUserDetails[0]['avatar']);
							}
							echo $flashMessage('Congratulation! user image is uploaded successfully', false);
						}
					}
				} else {
					echo $flashMessage('Oops! unable to upload image', false);
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
