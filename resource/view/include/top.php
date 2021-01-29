<!DOCTYPE html>
<html lang="en">

<?php

# =*|*=[ Calling Controller ]=*|*=
spl_autoload_register(function ($class) {
	if (file_exists('app/Http/Controllers/' . $class . '.php')) {
		include('app/Http/Controllers/' . $class . '.php');
	}
});

# =*|*=[ Object Defined ]=*|*=
$misc = new MiscellaneousController;

?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keyword" content="Doctors Appointment, Medical Service, Health Partner">
	<meta name="description" content="A Complete Medial Service Solution">
	<meta name="author" content="Medi Raj">

	<title>Medi Raj | Your Health Partner</title>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:600|Source+Sans+Pro:600,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php $misc->asset('all.css'); ?>" />
	<link rel="stylesheet" href="<?php $misc->asset('app.css'); ?>" />
</head>

<body class="ui-transparent-nav" data-fade_in="on-load">
