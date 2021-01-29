<?php

# =*|*=[ Object Defined ]=*|*=
$misc = new MiscellaneousController;
$admin = new AdminController;


# =*|*=[ Authenticate Access ]=*|*=
if (isset($_POST['loginAccess'])) {
	if (strlen($_POST['_token']) === 38) {
		$authAccess = $admin->tryLogin($_POST['email'], $misc->encrypt($_POST['password']));

		if (!empty($authAccess)) {
			//Create Logged In User Session
			$_SESSION['auth_log_time'] = date("Y-m-d H:i:s");
			$_SESSION['auth_log_id'] = $authAccess[0]['id'];
			$_SESSION['auth_log_name'] = $authAccess[0]['admin_name'];
			$_SESSION['auth_log_email'] = $authAccess[0]['admin_email'];
			$_SESSION['auth_log_type'] = $authAccess[0]['admin_role_type'];
			$_SESSION['auth_log_image'] = $authAccess[0]['admin_avatar'];
			$_SESSION['auth_log_status'] = $authAccess[0]['admin_status'];

			//If Valid Then Redirect to the Dashboard
			$misc->redirect('dashboard');
		} else {
			$misc->redirect('index');
		}
	}
}

?>

<!-- Login Page Content [Start] -->
<form class="form-horizontal m-t-30" action="" method="POST">
	<input type="hidden" name="_token" value="<?php echo $misc->token(); ?>">
	<div class="form-group">
		<label for="">Email</label>
		<input type="text" class="form-control" name="email" placeholder="Enter email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
	</div>
	<div class="form-group">
		<label for="">Password</label>
		<input type="password" class="form-control" name="password" placeholder="Enter password" autocomplete="off" />
	</div>
	<div class="form-group row m-t-20">
		<div class="col-6">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="customControlInline" name="remember">
				<label class="custom-control-label" for="customControlInline">Remember me</label>
			</div>
		</div>
		<div class="col-6 text-right">
			<button class="btn btn-primary w-md waves-effect waves-light" type="submit" name="loginAccess">
				Log In
			</button>
		</div>
	</div>
	<div class="form-group m-t-5 mb-0 row">
		<div class="col-12">
			<a href="forgot-password" class="text-muted"><i class="fas fa-lock text-primary"></i> Forgot your password?</a>
		</div>
	</div>
</form>
<!-- Login Page Content [End] -->