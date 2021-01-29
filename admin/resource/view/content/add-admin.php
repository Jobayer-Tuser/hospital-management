<?php

# =*|*=[ OBJECT DEFINED ]=*|*=
$misc = new MiscellaneousController;
$admin = new AdminController;



# =*|*=[ CREATE DATA ]=*|*=
/**
 * Create Form Validation by Token
 * Image File Name Generate and Validation Prior to Upload
 * If Validate Then Create Query will be Executed
 * Upload to the Specified Directory
 * Confirmation Notification Based on Execution Result
 */
if (isset($_POST['createNewAdmin'])) {
   if (!empty($_POST['_token'])) {
      $newFileName = "admin_image_" . date("YmdHis") . "_" . $_FILES['avatar']['name'];

      $fileValid = $misc->checkImage(
         $_FILES['avatar']['type'],
         $_FILES['avatar']['size'],
         $_FILES['avatar']['error']
      );

      if ($fileValid == 1) {
         $mobile = str_replace(' ', '', $_POST['mobile']);

         $createNewAdmin = $admin->createAdmin(
            $_POST['name'],
            $_POST['email'],
            $mobile,
            $_POST['nid'],
            @$_POST['gender'],
            $_POST['role'],
            $newFileName,
            $misc->encrypt($_POST['password']),
            $_POST['status']
         );

         if ($createNewAdmin > 0) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $GLOBALS['ADMINS_DIR'] . $newFileName);
            echo $misc->alertNotification('success', 'top', 10, 'a new admin data is created');
         } else {
            echo $misc->alertNotification('primary', 'top', 10, 'something went wrong');
         }
      }
   }
}

?>

<!-- =+|+= ADD ADMIN PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-8 offset-md-1 pt-4">
                     <form action="" method="POST" enctype="multipart/form-data" class="customFormInput" id="addAdminForm">
                        <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Full Name</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="text" name="name" placeholder="Enter Full Name" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Email</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="email" name="email" placeholder="Enter Email Address" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                              <span class="text-primary" id="emailError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Mobile No</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="tel" name="mobile" placeholder="01316 440504" pattern="[0-9]{5} [0-9]{6}" />
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
                           <label class="col-md-2 col-form-label"><strong>Role Type</strong></label>
                           <div class="col-md-9">
                              <select class="custom-select" name="role">
                                 <option selected>Please Select..</option>
                                 <option value="Root Admin">Root Admin</option>
                                 <option value="Administrator">Administrator</option>
                                 <option value="Editor">Editor</option>
                                 <option value="Author">Author</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="example-url-input" class="col-md-2 col-form-label"><strong>Upload Avatar</strong></label>
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
                           <label for="" class="col-md-2 col-form-label"><strong>Password</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="password" name="password" placeholder="e.g.aBc@125?45#" autocomplete="off" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>RE:Password</strong></label>
                           <div class="col-md-9">
                              <input class="form-control" type="password" name="confirmPassword" placeholder="e.g.aBc@125?45#" autocomplete="off" />
                              <span class="text-primary" id="passError"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Status</strong></label>
                           <div class="col-md-9">
                              <select class="custom-select" name="status">
                                 <option selected>Please Select..</option>
                                 <option value="Active">Active</option>
                                 <option value="Inactive">Inactive</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-9 offset-md-2 pt-4">
                              <button type="submit" name="createNewAdmin" class="btn btn-primary btn-block waves-effect waves-light">
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
<!-- =+|+= ADD ADMIN PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {

      /**
       * To Prevent Duplicate Form Data Submission
       * Read Data Based on Each Required Input Field
       * All The Request is Generate By AJAX
       */
      function isExisted(tableName, columnName, inputValue, id, message) {
         $.ajax({
            url: 'sync.php',
            type: 'POST',
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


      /** 
       * Required Input Field Validation Such AS
       * [1] Email Input
       * [2] Mobile Input
       * [3] NID Input
       * Data Validation is Execute On Change or Click Event as well
       */
      let email;
      let mobile;
      let nid;

      $(document).on('change click', '[name="email"]', function() {
         email = $(this).val();
         isExisted('admins', 'admin_email', email, '#emailError', 'Oops! this email is already exist');
      });

      $(document).on('change click', '[name="mobile"]', function() {
         mobile = $(this).val().replace(" ", "");
         console.log(mobile);
         isExisted('admins', 'admin_mobile', mobile, '#mobileError', 'Oops! this mobile number is already exist');
      });

      $(document).on('change click', '[name="nid"]', function() {
         nid = $(this).val();
         isExisted('admins', 'admin_nidcard_no', nid, '#nidError', 'Oops! this nid card no is already exist');
      });



      /**
       * Prevent Form Submission Based On
       * ["Email Error" | "Mobile Error" | "NID Error"]
       * Also Prevent on Password MisMatch
       */
      $(document).on('submit', '#addAdminForm', function(e) {
         let emailError = $('#emailError').html();
         let mobileError = $('#mobileError').html();
         let nidError = $('#nidError').html();
         let password = $('[name="password"]').val();
         let rePassword = $('[name="confirmPassword"]').val();

         if (password !== rePassword) {
            $('#passError').html('Password is not match, please try again');
         }
         if (password === rePassword && emailError == '' && mobileError == '' && nidError == '') {
            return true;
         } else {
            e.preventDefault();
            return false;
         }
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->