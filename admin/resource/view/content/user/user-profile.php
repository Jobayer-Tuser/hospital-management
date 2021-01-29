<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ReadController
 */
$misc = new MiscellaneousController;
$read = new ReadController;



/**
 * [Read Data]
 * Only Accessible If User Request on POST Method and Create a Session
 * Fetch All Records Based on Session
 */
if (isset($_POST['userProfile'])) {
	$_SESSION['get_profile_id'] = $_POST['id'];
}
$userProfileDetails = $read->findOn('users', 'id', $_SESSION['get_profile_id']);
$totalOrder = $read->calculateTotal('inventory', 'price', 'user_id', '"'. $userProfileDetails[0]['user_id'] .'"');

if(!empty($userProfileDetails[0]['avatar'])) {
	$userImage = $GLOBALS['USERS_DIR'] . $userProfileDetails[0]['avatar'];
} else {
	$userImage = 'public/assets/images/placeholder_small.jpg';
}

?>


<!-- =+|+= USER PROFILE PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<div class="my-3 d-flex justify-content-center">
								<img class="rounded-circle shadow" alt="200x200" src="<?php echo $userImage; ?>" style="width:94px; height:96px;">
							</div>
							<h4 class="card-title font-18 text-center py-2">
								<?php echo $userProfileDetails[0]['full_name']; ?>
							</h4>
							<div class="pl-3">
								<ul class="list-group list-group-flush font-14">
									<li class="list-group-item">
										<div>
											<i class="fas fa-envelope text-secondary"></i>
											<span class="float-right">
												<?php echo $userProfileDetails[0]['email']; ?>
											</span>
										</div>
									</li>
									<li class="list-group-item">
										<div>
											<i class="fas fa-phone-alt text-success"></i>
											<span class="float-right">
												<?php echo $userProfileDetails[0]['mobile']; ?>
											</span>
										</div>
									</li>
									<li class="list-group-item">
										<div>
											<i class="fas fa-venus-mars text-warning"></i>
											<span class="float-right">Male</span>
										</div>
									</li>
									<li class="list-group-item">
										<div>
											<i class="fas fa-map-marker-alt text-primary"></i>
											<span class="float-right">Narayanganj, Dhaka</span>
										</div>
									</li>
									<li class="list-group-item">
										<div>
											<i class="fas fa-chalkboard-teacher text-danger"></i>
											<span class="float-right">Redmi Note 7</span>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card m-b-30 bg-primary text-white">
						<div class="card-body">
							<div class="display-4" style="font-size:1.5em; font-weight:400;">
								Total Order: 
								<?php 
									if($totalOrder[0]['total'] > 0) {
										echo $totalOrder[0]['total'] . ' tk/BDT';
									} else {
										echo 'Not Yet';
									}
								?> 
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Service Title</th>
										<th scope="col">Product Name</th>
										<th scope="col">Price</th>
										<th scope="col">On Date</th>
									</tr>
								</thead>
								<tbody>

									<?php
									/**
									 * Conditional Check and Assign a Variable for Increment
									 * Read All The Required Table Such As:
									 * [1] Inventory
									 * [2] Categories
									 */
									if (!empty($userProfileDetails)) {
										$n = 1;
										$getCartDetails = $read->findOn('inventory', 'user_id', '"' . $userProfileDetails[0]['user_id'] . '"');
										if (!empty($getCartDetails) && is_array($getCartDetails)) {
											foreach ($getCartDetails as $each) {
												echo '
													<tr>
														<td class="font-weight-bold">' . $n . '</td>
														<td>' . $each['service'] . '</td>
														<td>' . $each['product'] . '</td>
														<td>' . $each['price'] . ' tk/BDT</td>
														<td>' . $misc->dateTime($each['created_at']) . '</td>
													</tr>
													';
												$n++;
											}
										}
									}
									?>

								</tbody>
							</table>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Appointment On</th>
										<th scope="col">Doctor Name</th>
										<th scope="col">Department</th>
										<th scope="col">Status</th>
									</tr>
								</thead>
								<tbody>

									<?php
									/**
									 * Conditional Check and Assign a Variable for Increment
									 * Read All The Required Table Such As:
									 * [1] Inventory
									 * [2] Categories
									 */
									if (!empty($userProfileDetails)) {
										$n = 1;
										$getAppointment = $read->findOn('appointments', 'user_id', '"' . $userProfileDetails[0]['user_id'] . '"');
										if (!empty($getAppointment) && is_array($getAppointment)) {
											foreach ($getAppointment as $eachAppoint) {
												echo '
													<tr>
														<td class="font-weight-bold">' . $n . '</td>
														<td>' . $misc->dateTime($eachAppoint['date_time']) . '</td>
														<td>' . $eachAppoint['doctor_name'] . '</td>
														<td>' . $eachAppoint['department'] . '</td>
														<td>' . $eachAppoint['status'] . '</td>
													</tr>
													';
												$n++;
											}
										}
									}
									?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= USER PROFILE PAGE CONTENT [END] =+|+= -->