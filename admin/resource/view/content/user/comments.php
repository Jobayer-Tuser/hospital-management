<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ReadController
 * [3] DeleteController
 */
$misc = new MiscellaneousController;
$read = new ReadController;
$delete = new DeleteController;



/**
 * [Read Data]
 */
$fetchComments = $read->all('comments');

?>

<style type="text/css">
	/* Required Styles For User Comments Section Only */
	input[switch]+label:before {
		line-height: 19px;
	}
</style>

<!-- =+|+= USER COMMENTS PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="pt-3">
						<table class="table dt-responsive datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th scope="col" style="width: 5%;">#</th>
									<th scope="col" style="width: 12%;">User Name</th>
									<th scope="col" style="width: 12%;">User Email</th>
									<th scope="col" style="width: 10%;">User Phone</th>
									<th scope="col" style="width: 38%;">Comments</th>
									<th scope="col" style="width: 15%;">Date On</th>
									<th scope="col" style="width: 8%;">Action</th>
								</tr>
							</thead>
							<tbody>

								<?php
								/**
								 * Conditional Check and Assign a Variable for Increment
								 * Read All The Required Table Such As:
								 * [1] Users
								 * Checked Value Defined Based on Condition
								 */
								if (!empty($fetchComments) && is_array($fetchComments)) {
									$n = 1;
									foreach ($fetchComments as $each) {
										$user = $read->findOn('users', 'id', $each['user_id']);

										if ($each['status'] == "Published") {
											$isChecked = "checked";
										} else {
											$isChecked = "";
										}
										
								?>

										<tr>
											<td class="font-weight-bold">
												<?php echo $n; ?>
											</td>
											<td>
												<?php echo $user[0]['full_name']; ?>
											</td>
											<td>
												<?php echo $user[0]['email']; ?>
											</td>
											<td>
												<?php echo $user[0]['mobile']; ?>
											</td>
											<td>
												<?php echo stripslashes($each['comments']); ?>
											</td>
											<td>
												<?php echo $misc->dateTime($each['created_at']); ?>
											</td>
											<td>
												<div>
													<input type="checkbox" id="switch<?php echo $n; ?>" switch="none" <?php echo $isChecked; ?> name="toggle" value="<?php echo $each['id']; ?>" />
													<label for="switch<?php echo $n; ?>" data-toggle="toggle" data-on-label="On" data-off-label="Off" class="mb-0 pt-1"></label>
												</div>
											</td>
										</tr>

								<?php
										$n++;
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
<!-- =+|+= USER COMMENTS PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
	$(document).ready(function() {

		//Toggle Button Action Perform
		$(document).on('change', 'input[name=toggle]', function() {
			let data = $(this).prop('checked');
			let userID = $(this).val();
			let isActive;

			if (data == true) {
				isActive = "Published";
			} else {
				isActive = "Pending";
			}

			$.ajax({
				url: 'sync.php',
				type: 'POST',
				data: {
					action: "CHANGE_PUBLICATION_STATUS",
					status: isActive,
					id: userID
				},
				success: function(data) {
					if (data == 1) {
						location.reload();
					}
				}
			});
		});
	});
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->