<?php

/*
| -------------------------------------------------------------------
| Authentic User Login Access
| -------------------------------------------------------------------
| In order to make sure authentication for this "API" check and match 
| with "api_key". Execute Login Access Query if "email" and "password" 
| is existed and "Active". If both condition is true the return an 
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
$misc = new MiscellaneousController;
$auth = new AdminController;


try {
   if (!empty($_REQUEST['api_key'])) {
      if ($_REQUEST['api_key'] === authenticate) {
         if (!empty($data['email']) && !empty($data['password'])) {
            $authAccess = $auth->loginAccess($data['email'], $misc->encrypt($data['password']));
            if (!empty($authAccess) && is_array($authAccess)) {
               echo json_encode($authAccess, JSON_PRETTY_PRINT);
            } else {
               echo $flashMessage('Oops!, credential is not match', false);
            }
         } else {
            echo $flashMessage('Oops!, something went wrong', false);
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
