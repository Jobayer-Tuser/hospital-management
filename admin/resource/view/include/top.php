<?php

/**
 * ------------------------------------------
 * Object Defined
 * ------------------------------------------
 * 1. Resource Controller
 */
spl_autoload_register(function ($class) {
	if (file_exists('app/Http/Controllers/' . $class . '.php')) {
		include('app/Http/Controllers/' . $class . '.php');
	}
});

$resc = new ResourceController;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="Admin Dashboard">
	<meta name="author" content="Medi Raj">

	<title><?php echo $resc->pagetTitle('Medi Raj'); ?></title>

	<link rel="shortcut icon" href="<?php echo $resc->asset('logo-sm.png'); ?>" type="image/png">
	<link href="<?php echo $resc->asset('morris.css', 'plugins/morris'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('dataTables.bootstrap4.min.css', 'plugins/datatables');?>" rel="stylesheet" type="text/css" >
	<link href="<?php echo $resc->asset('bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('metismenu.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('icons.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('all.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('datepicker.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('select2.css', 'plugins/select2'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('style.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo $resc->asset('app.css'); ?>" rel="stylesheet" type="text/css">

	<!-- jQuery Initiate -->
	<script src="<?php echo $resc->asset('jquery-3.5.1.min.js');?>"></script>
</head>

<body>
	<!-- =+|+= Application Top Page Content [Start] =+|+= -->
	<div id="wrapper">

		<?php

		/**
		 * Required Pages Such as: 
		 * [1] Application Header Page
		 * [2] Application Sidebar Page
		 */
		include('header.php');
		include('sidebar.php');
		
		?>

		<div class="content-page">
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<div class="page-title-box">
								<h4 class="page-title">
									<?php echo $resc->pagetTitle(); ?>
								</h4>
								<ol class="breadcrumb">
									<li class="breadcrumb-item active">Welcome to Raz Medicare</li>
									<li class="breadcrumb-item">
										<a href="dashboard">Home</a>
									</li>
									<?php echo $resc->breadCrumb(); ?>
									<li class="breadcrumb-item">
										<?php echo $resc->pagetTitle(); ?>
									</li>
								</ol>
							</div>
						</div>
					</div>
	<!-- =+|+= Application Top Page Content [End] =+|+= -->