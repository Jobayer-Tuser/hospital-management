<?php

# =*|*=[ Object Defined ]=*|*=
$misc = new MiscellaneousController;
$admin = new AdminController;


# =*|*=[ Update Data ]=*|*=
if (isset($_POST['resetPassword'])) {
   if (strlen($_POST['_token']) === 32) {
      $update = $admin->updatePassword($misc->encrypt($_POST['newPassword']), $_SESSION['forgot_password_id']);

      if (!empty($update)) {
         session_destroy();
         $misc->redirect('index');
      } else {
         session_destroy();
         $misc->redirect('index');
      }
   }
}

?>

<!-- Reset Password Page Content [Start] -->
<form class="form-horizontal m-t-30" action="" method="POST">
   <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>">
   <div class="form-group">
      <label for="">New Password</label>
      <input type="password" class="form-control" name="newPassword" autocomplete="off" placeholder="Enter New Password" />
   </div>
   <div class="form-group">
      <label for="">Confirm Password</label>
      <input type="password" class="form-control" name="rePassword" autocomplete="off" placeholder="Enter Confirm Password" />
      <span class="text-primary" id="errorMatch"></span>
   </div>
   <div class="form-group row m-t-20">
      <div class="col-12 text-right">
         <button class="btn btn-primary w-md waves-effect waves-light" type="submit" name="resetPassword">
            Reset Password
         </button>
      </div>
   </div>
   <div class="form-group m-t-5 mb-0 row">
      <div class="col-12">
         <a href="index" class="text-muted"><i class="fas fa-sign-in-alt text-primary"></i> Login here?</a>
      </div>
   </div>
</form>
<!-- Reset Password Page Content [End] -->


<!-- JavaScript Content [Start] -->
<script type="text/javascript">
   $(document).ready(function() {
      $(document).on('click', '[name="resetPassword"]', function(e) {
         let newPassword = $('[name="newPassword"]').val();
         let rePassword = $('[name="rePassword"]').val();

         if (newPassword === rePassword) {
            return true;
         } else {
            e.preventDefault();
            $('#errorMatch').html('Oops! both password is not match');
            return false;
         }
      });
   });
</script>
<!-- JavaScript Content [End] -->