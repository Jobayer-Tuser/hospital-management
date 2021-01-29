<?php


/**
 * Object Defined
 * Accessible to the Class Methods Such as:
 * ----------------------------------------
 * 1. Resource Controller
 */
spl_autoload_register(function ($class) {
	if (file_exists('app/Http/Controllers/' . $class . '.php')) {
		include('app/Http/Controllers/' . $class . '.php');
	}
});

$resc = new ResourceController;

$misc = new MiscellaneousController;
$admin = new AdminController;
$read = new ReadController;

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="Admin Dashboard" />
	<meta name="author" content="Md. Abdullah Al Mamun Roni" />
	
	<title><?php echo $resc->pagetTitle('Medi Raj'); ?></title>

	<link rel="shortcut icon" href="<?php echo $resc->asset('logo-sm.png'); ?>" type="image/png">
	<link href="<?php echo $resc->asset('bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('metismenu.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('icons.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('style.css'); ?>" rel="stylesheet" type="text/css">

	<script src="<?php echo $resc->asset('jquery-3.5.1.min.js'); ?>"></script>
</head>

<body>
	<!-- =+|+= Application Authentication Top Page Content [Start]  =+|+= -->
	<div class="account-pages"></div>
	<div class="wrapper-page">
		<div class="card">
			<div class="card-body">
				<h3 class="text-center m-0">
					<a href="index" class="logo logo-admin">
						<img src="<?php echo $resc->asset('logo.png'); ?>" height="30" alt="logo">
					</a>
				</h3>
				<div class="p-3">
					<?php if ($resc->pagetTitle() === "Forgot Password") : ?>
						<h4 class="text-muted font-18 mb-3 text-center">Forgot Password !</h4>
						<div class="alert alert-light" role="alert" id="emailConfirm">
							Enter your Email and instructions will be sent to you!
						</div>
					<?php elseif ($resc->pagetTitle() === "Reset Password") : ?>
						<h4 class="text-muted font-18 mb-0 text-center">Reset Password !</h4>
						<p class="text-muted text-center">Reset password to continue to Raz Medicare App.</p>
					<?php else : ?>
						<h4 class="text-muted font-18 mb-0 text-center">Welcome Back !</h4>
						<p class="text-muted text-center">Sign in to continue to Raz Medicare App.</p>
					<?php endif; ?>
	<!-- =+|+= Application Authentication Top Page Content [End]  =+|+= -->