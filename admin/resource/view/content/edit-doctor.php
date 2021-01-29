<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
 * [3] CreateController
 * [4] ReadController
 */
$misc = new MiscellaneousController;
$read = new ReadController;
$update = new UpdateController;



/**
 * [Required Variables]
 * 
 * Root Path Where Image File Stored
 */
$path = $GLOBALS['ROOT_APPLICATION'] . 'public/uploads/doctors/';



/**
 * [Update Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * String Replace for Mobile and Convert Array to String
 * Base on Condition: Generate Image File Name and Uploaded File Validation
 * Execute Update Query Based on Condition and Flash Confirmation Notification
 */
if (isset($_POST['updateDoctorData'])) {
   if (strlen($_POST['_token']) === 32) {
      $mobile = str_replace(' ', '', $_POST['mobile']);
      $schedule = implode(', ', $_POST['schedule']);

      if (!empty($_FILES['avatar']['name'])) {
         $newFileName = date("YmdHis") . "_" . $_FILES['avatar']['name'];
         $fileValidation = $misc->checkImage($_FILES['avatar']['type'], $_FILES['avatar']['size'], $_FILES['avatar']['error']);
         if ($fileValidation === 1) {
            $updateDoctorData = $update->updateDoctorInc(
               $_POST['department'],
               $_POST['name'],
               $_POST['email'],
               $mobile,
               $_POST['gender'],
               $_POST['nid'],
               $newFileName,
               $path . $newFileName,
               $_POST['specialty'],
               $_POST['degree'],
               $_POST['designation'],
               $_POST['organization'],
               $_POST['orgAddress'],
               $_POST['chember'],
               $_POST['location'],
               $schedule,
               $misc->sqlTime($_POST['start']),
               $misc->sqlTime($_POST['end']),
               $_POST['status'],
               $_SESSION['get_doctor_id']
            );
            if ($updateDoctorData > 0) {
               if (!empty($_SESSION['get_doctor_avatar'])) {
                  move_uploaded_file($_FILES['avatar']['tmp_name'], $GLOBALS['DOCTORS_DIR'] . $newFileName);
                  unlink($GLOBALS['DOCTORS_DIR'] . $_SESSION['get_doctor_avatar']);
               } else {
                  move_uploaded_file($_FILES['avatar']['tmp_name'], $GLOBALS['DOCTORS_DIR'] . $newFileName);
               }
               echo $misc->alertNotification('success', 'top', 5, 'doctor data is updated successfully');
            } else {
               echo $misc->alertNotification('primary', 'top', 5, 'something went wrong');
            }
         }
      } else {
         $updateDoctorData = $update->updateDoctorExc(
            $_POST['department'],
            $_POST['name'],
            $_POST['email'],
            $mobile,
            $_POST['gender'],
            $_POST['nid'],
            $_POST['specialty'],
            $_POST['degree'],
            $_POST['designation'],
            $_POST['organization'],
            $_POST['orgAddress'],
            $_POST['chember'],
            $_POST['location'],
            $schedule,
            $misc->sqlTime($_POST['start']),
            $misc->sqlTime($_POST['end']),
            $_POST['status'],
            $_SESSION['get_doctor_id']
         );
         if ($updateDoctorData > 0) {
            echo $misc->alertNotification('success', 'top', 5, 'doctor data is updated successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 5, 'something went wrong');
         }
      }
   }
}



/**
 * [Read Data]
 */
if (isset($_POST['editDoctorData'])) {
   $_SESSION['get_doctor_id'] = $_POST['id'];
}
$fetchDepartment = $read->findOn('departments', 'status', '"Active"');
$fetchDoctor = $read->findOn('doctors', 'id', $_SESSION['get_doctor_id']);

$_SESSION['get_doctor_avatar'] = $fetchDoctor[0]['avatar'];

?>

<style>
   /* Required Style for This Page Only */
   .only-timepicker .datepicker--nav,
   .only-timepicker .datepicker--content {
      display: none;
   }

   .only-timepicker .datepicker--time {
      border-top: none;
   }
</style>


<!-- =+|+= EDIT DOCTOR PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-8 offset-md-1 pt-4">
                     <form action="" method="POST" enctype="multipart/form-data" class="customFormInput" id="addDoctorForm">
                        <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                        <input type="hidden" name="update_id" value="<?php echo $fetchDoctor[0]['id']; ?>" />
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Full Name</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="name" value="<?php echo $fetchDoctor[0]['full_name']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Email</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="email" name="email" value="<?php echo $fetchDoctor[0]['email']  ?>" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                              <span class="text-primary" id="emailError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Mobile No</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="tel" name="mobile" value="<?php echo substr($fetchDoctor[0]['mobile'], 0, 5) . "" . substr($fetchDoctor[0]['mobile'], 5, 10); ?>" pattern="[0-9]{5} [0-9]{6}" />
                              <span class="text-primary" id="mobileError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>NID Card No</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="nid" value="<?php echo $fetchDoctor[0]['nid_card_no']; ?>" pattern="[0-9]{4} [0-9]{3} [0-9]{3}" />
                              <span class="text-primary" id="nidError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Gender</strong></label>
                           <div class="col-md-9 pxt-7">
                              <div class="custom-control custom-radio custom-control-inline">
                                 <input type="radio" id="gender1" name="gender" class="custom-control-input" value="Male" <?php if ($fetchDoctor[0]['gender'] == "Male") echo 'checked'; ?> />
                                 <label class="custom-control-label pxt-2" for="gender1">Male</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                 <input type="radio" id="gender2" name="gender" class="custom-control-input" value="Female" <?php if ($fetchDoctor[0]['gender'] == "Female") echo 'checked'; ?> />
                                 <label class="custom-control-label pxt-2" for="gender2">Female</label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Avatar</strong></label>
                           <div class="col-md-9">
                              <div class="input-group">
                                 <div class="input-group-prepend">
                                    <button class="btn btn-secondary" type="button" id="uploadIcon">
                                       <i class="mdi mdi-cloud-upload"></i>
                                    </button>
                                 </div>
                                 <div class="custom-file">
                                    <input type="file" class="custom-file-input imageFile" name="avatar" aria-describedby="uploadIcon" onchange="readURL(this);" set-to="div1" />
                                    <label class="custom-file-label fileName" for="avatar">
                                       <?php echo !empty($fetchDoctor[0]['avatar']) ? $fetchDoctor[0]['avatar'] : 'Choose file'; ?>
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Department</strong></label>
                           <div class="col-md-9">
                              <select class="custom-select" name="department" id="department">

                                 <?php
                                 if (!empty($fetchDepartment) && is_array($fetchDepartment)) {
                                    foreach ($fetchDepartment as $each) {
                                       echo '<option value="' . $each['id'] . '"';
                                       if ($each['id'] === $fetchDoctor[0]['department_id'])
                                          echo 'selected';
                                       echo '>' . $each['title'] . '</option>';
                                    }
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Specialty</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="specialty" value="<?php echo $fetchDoctor[0]['specialty']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Degree</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="degree" value="<?php echo $fetchDoctor[0]['degree']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Designation</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="designation" value="<?php echo $fetchDoctor[0]['designation']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Organization</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="organization" value="<?php echo $fetchDoctor[0]['organization']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Address</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="orgAddress" value="<?php echo $fetchDoctor[0]['address']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Chember</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="chember" value="<?php echo $fetchDoctor[0]['chember']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Location</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="location" value="<?php echo $fetchDoctor[0]['location']; ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Schedule</strong></label>
                           <div class="col-md-9">
                              <select class="select2 form-control select2-multiple" multiple="multiple" data-value="Choose ..." name="schedule[]" id="schedule">

                                 <?php
                                 /**
                                  * Convert String into Array as Selected
                                  * Based on Condition Create Selected Value
                                  * Compare Both Array and Get The Difference
                                  */
                                 $selected = explode(', ', $fetchDoctor[0]['schedule']);
                                 $days = $misc->dayFull();

                                 if (is_array($selected) && !empty($selected)) {
                                    foreach ($selected as $eachSelect) {
                                       echo '<option value="' . $eachSelect . '" selected>' . $eachSelect . '</option>';
                                    }
                                    $difference = array_diff($days, $selected);
                                    foreach ($difference as $eachDay) {
                                       echo '<option value="' . $eachDay . '">' . $eachDay . '</option>';
                                    }
                                 } else {
                                    if (is_array($days)) {
                                       foreach ($days as $each) {
                                          if ($each == $eachSelect) {
                                             echo '<option value="' . $each . '">' . $each . '</option>';
                                             break;
                                          }
                                       }
                                    }
                                 }
                                 ?>

                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Visiting</strong></label>
                           <div class="col-md-9">
                              <div class="row">
                                 <div class="col-6">
                                    <input class="form-control only-time" type="text" name="start" value="<?php echo $misc->timeOnly($fetchDoctor[0]['start_time']); ?>" data-language='en' data-timepicker="true" />
                                 </div>
                                 <div class="col-6">
                                    <input class="form-control only-time" type="text" name="end" value="<?php echo $misc->timeOnly($fetchDoctor[0]['end_time']); ?>" data-language='en' data-timepicker="true" />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Status</strong></label>
                           <div class="col-md-9">
                              <select class="custom-select" name="status">
                                 <option <?php if ($fetchDoctor[0]['end_time'] == "Active") echo 'selected'; ?>>Active</option>
                                 <option <?php if ($fetchDoctor[0]['end_time'] == "Inactive") echo 'selected'; ?>>Inactive</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-9 offset-md-2 pt-4">
                              <button type="submit" name="updateDoctorData" class="btn btn-primary btn-block waves-effect waves-light">
                                 Confirm &amp; Save
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="col-md-2">
                     <div class="pt-4">
                        <img class="rounded shadow mr-2 mo-mb-2" alt="" width="180" height="180" src="<?php echo $GLOBALS['DOCTORS_DIR'] . $fetchDoctor[0]['avatar']; ?>" data-holder-rendered="true" id="div1" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= EDIT DOCTOR PAGE CONTENT [END] =+|+= -->