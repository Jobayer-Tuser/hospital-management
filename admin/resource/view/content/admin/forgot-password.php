<?php

# =*|*=[ Object Defined ]=*|*=
$misc = new MiscellaneousController;
$read = new ReadController;


# =*|*=[ Create An Session Based on Validation ]=*|*=
if (isset($_POST['forgotPassword'])) {
   if (strlen($_POST['_token']) === 32) {
      if ($_POST['isExist'] == 'true') {
         $readExistedData = $read->findOn('admins', 'admin_email', '"' . $_POST['email'] . '"', 'admin_status', '"Active"');

         if (!empty($readExistedData)) {
            $_SESSION['forgot_password_id'] = $readExistedData[0]['id'];
            $misc->redirect('reset-password');
         } else {
            $misc->redirect('forgot-password');
         }
      }
   }
}

?>


<!-- Forgot Password Page Content [Start] -->
<form class="form-horizontal m-t-30" action="" method="POST">
   <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>">
   <input type="hidden" name="isExist" value="">
   <div class="form-group">
      <label for="">Email</label>
      <input type="email" class="form-control" name="email" placeholder="Enter email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
      <span class="text-primary" id="emailError"></span>
   </div>
   <div class="form-group row m-t-20">
      <div class="col-12 text-right">
         <button class="btn btn-primary w-md waves-effect waves-light" type="submit" name="forgotPassword" id="forgotPassword">
            Confirm and Send
         </button>
      </div>
   </div>
   <div class="form-group m-t-5 mb-0 row">
      <div class="col-12">
         <a href="index" class="text-muted"><i class="fas fa-sign-in-alt text-primary"></i> Login here?</a>
      </div>
   </div>
</form>
<!-- Forgot Password Page Content [End] -->


<!-- JavaScript Content [Start] -->
<script type="text/javascript">
   $(document).ready(function() {

      //AJAX Input Field Validation
      function isExisted(tableName, columnName, inputValue) {
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
                  $('#emailConfirm').removeClass('alert-warning').addClass('alert-light').html(
                     'Enter your Email and instructions will be sent to you!');
                  $('[name="isExist"]').val('true');
               } else {
                  $('#emailConfirm').removeClass('alert-light').addClass('alert-warning').html(
                     'Oops! Your credential is not match');
               }
            }
         });
      }


      //Get The Existed Value
      let email;
      $(document).on('change click', '[name="email"]', function() {
         email = $(this).val();
         if (email !== '') {
            isExisted('admins', 'admin_email', email);
         } else {
            $('#emailConfirm').removeClass('alert-warning').addClass('alert-light').html(
               'Enter your Email and instructions will be sent to you!');
         }
      });


      //Form Submission Control
      $(document).on('click', '#forgotPassword', function(e) {
         if ($('[name="isExist"]').val() !== '') {
            return true;
         } else {
            e.preventDefault();
            return false;
         }
      });

   });
</script>
<!-- JavaScript Content [End] -->