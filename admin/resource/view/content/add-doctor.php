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
$create = new CreateController;
$read = new ReadController;



/**
 * [Create Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Generate Image File Name
 * Uploaded File Validation
 * String Replace for Mobile and Convert Array to String
 * Execute Create Query Based on Condition and Flash Confirmation Notification
 */
if (isset($_POST['createNewDoctor'])) {
   if (strlen($_POST['_token']) === 32) {
      $newFileName = date("YmdHis") . "_" . $_FILES['avatar']['name'];
      $fileValidation = $misc->checkImage($_FILES['avatar']['type'], $_FILES['avatar']['size'], $_FILES['avatar']['error']);
      if ($fileValidation === 1) {
         $mobile = str_replace(' ', '', $_POST['mobile']);
         $schedule = implode(', ', $_POST['schedule']);
         $addNewDoctorData = $create->addDoctor(
            $_POST['department'],
            $_POST['name'],
            $_POST['email'],
            $mobile,
            $_POST['gender'],
            $_POST['nid'],
            $newFileName,
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
            $_POST['status']
         );
         if ($addNewDoctorData > 0) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $GLOBALS['DOCTORS_DIR'] . $newFileName);
            echo $misc->alertNotification('success', 'top', 5, 'a new doctor data is created successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 5, 'something went wrong');
         }
      }
   }
}



/**
 * [Read Data]
 */
$fetchDepartment = $read->findOn('departments', 'status', '"Active"');

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


<!-- =+|+= ADD DOCTOR PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-8 offset-md-1 pt-4">
                     <form action="" method="POST" enctype="multipart/form-data" class="customFormInput" id="addDoctorForm">
                        <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Full Name</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="name" placeholder="Dr. Kabir Khan" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Email</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="email" name="email" placeholder="kabirkhan@gmail.com" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                              <span class="text-primary" id="emailError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Mobile No</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="tel" name="mobile" placeholder="e.g. 01316 440504" pattern="[0-9]{5} [0-9]{6}" />
                              <span class="text-primary" id="mobileError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>NID Card No</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="nid" placeholder="3254 125 945" pattern="[0-9]{4} [0-9]{3} [0-9]{3}" />
                              <span class="text-primary" id="nidError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Gender</strong></label>
                           <div class="col-md-9 pxt-7">
                              <div class="custom-control custom-radio custom-control-inline">
                                 <input type="radio" id="gender1" name="gender" class="custom-control-input" value="Male" />
                                 <label class="custom-control-label pxt-2" for="gender1">Male</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                 <input type="radio" id="gender2" name="gender" class="custom-control-input" value="Female" />
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
                                    <label class="custom-file-label fileName" for="avatar">Choose file</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Department</strong></label>
                           <div class="col-md-9">
                              <select class="custom-select" name="department" id="department">
                                 <option selected disabled>Please Select..</option>
                                 <?php
                                 if (!empty($fetchDepartment) && is_array($fetchDepartment)) {
                                       foreach ($fetchDepartment as $each) {
                                          echo '<option value="' . $each['id'] . '">' . $each['title'] . '</option>';
                                       }
                                    }
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Specialty</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="specialty" placeholder="Neuro Medicine" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Degree</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="degree" placeholder="MBBS, MS (Neurosurgery)" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Designation</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="designation" placeholder="Assistant Professor" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Organization</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="organization" placeholder="Dhaka Medical College University" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Address</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="orgAddress" placeholder="Dhaka-1248, Bangladesh" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Chember</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="chember" placeholder="Popular Diagonstic Center Ltd." />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Location</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="location" placeholder="Dhanmondi-1345, Dhaka" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Schedule</strong></label>
                           <div class="col-md-9">
                              <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="schedule[]" id="schedule">
                                 <?php
                                 if (is_array($misc->dayFull())) {
                                    foreach ($misc->dayFull() as $each) {
                                       echo '<option value="' . $each . '">' . $each . '</option>';
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
                                    <input class="form-control only-time" type="text" name="start" placeholder="<?php echo date('H:i a'); ?>" data-language='en' data-timepicker="true" />
                                 </div>
                                 <div class="col-6">
                                    <input class="form-control only-time" type="text" name="end" placeholder="<?php echo date('H:i a', strtotime('+2 hours +30 minutes')); ?>" data-language='en' data-timepicker="true" />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Status</strong></label>
                           <div class="col-md-9">
                              <select class="custom-select" name="status">
                                 <option selected disabled>Please Select..</option>
                                 <option value="Active">Active</option>
                                 <option value="Inactive">Inactive</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-9 offset-md-2 pt-4">
                              <button type="submit" name="createNewDoctor" class="btn btn-primary btn-block waves-effect waves-light">
                                 Confirm &amp; Save
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="col-md-2">
                     <div class="pt-4">
                        <img class="rounded shadow mr-2 mo-mb-2" alt="" width="180" height="180" src="<?php $misc->asset('placeholder.jpg'); ?>" data-holder-rendered="true" id="div1" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= ADD DOCTOR PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {

      //AJAX Input Field Validation
      function isExisted(tableName, columnName, inputValue, id, message) {
         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "INPUT_VALIDATION",
               table: tableName,
               column: columnName,
               name: inputValue
            },
            success: function(data) {
               if (data == 1) {
                  $(id).html(message);
               } else {
                  $(id).html('');
               }
            }
         });
      }


      //Duplicate Prevention Field
      let email;
      let mobile;
      let nid;

      $(document).on('change', '[name="email"]', function() {
         email = $(this).val();
         if (email != '') {
            isExisted('doctors', 'email', email, '#emailError', 'Oops! this email is already exist');
         }
      });
      $(document).on('change', '[name="mobile"]', function() {
         mobile = $(this).val().replace(" ", "");
         if (mobile != '') {
            isExisted('doctors', 'mobile', mobile, '#mobileError', 'Oops! this mobile number is already exist');
         }
      });
      $(document).on('change', '[name="nid"]', function() {
         nid = $(this).val();
         if (nid != '') {
            isExisted('doctors', 'nid_card_no', nid, '#nidError', 'Oops! this nid card no is already exist');
         }
      });


      //Form Submit Validation
      $(document).on('submit', '#addDoctorForm', function(e) {
         let emailError = $('#emailError').html();
         let mobileError = $('#mobileError').html();
         let nidError = $('#nidError').html();
         let department = $('#department').val();
         let schedule = $('#schedule').val();
         let start = $('[name="start"]').val();
         let end = $('[name="end"]').val();

         if (emailError == '' && mobileError == '' && nidError == '' && department != '' && schedule != '' && start != '' && end != '') {
            return true;
         } else {
            e.preventDefault();
            return false;
         }
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->