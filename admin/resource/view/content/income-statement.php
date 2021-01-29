<?php

/**
 * [Object Defined]
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ComponentController
 * [3] CreateController
 * [4] ReadController
 * [5] UpdateController
 * [6] DeleteController
 */
$misc = new MiscellaneousController;
$comp = new ComponentController;
$create = new CreateController;
$read = new ReadController;
$update = new UpdateController;
$delete = new DeleteController;


/**
 * [Delete Data]
 * 
 * Read All The Statement Data Based On Request ID
 * Assign Empty Array to Get All The ID's Which will be Execute to Delete
 * Condition To Push All The ID's From Statement and Statement Details through Loop
 * 
 * Assign Null String To Convert ID's Array Into SQL IN Operator format
 * Condition To Delete Only Account Category if Statement or Statement Details Data is not Exist
 * Confirmation Notification and Refresh Page Based on Account Categories Query is Executed
 * 
 * if Statement and Statement Details Data is Avialable.... 
 * Multiple Delete Query is Executed for Statement Details and Then Statement and Then Category Table Data
 * Confirmation Notification and Refresh Page Based on All Query is Executed
 * 
 * NOTE: Because of Relationship Syntax in MySQL, must be careful on "On Delete Restricted"
 */
if (isset($_REQUEST['did'])) {
	$fetchStatement = $read->findOn('statement', 'account_id', $_REQUEST['did']);

	$statements = [];
	$statementDetails = [];

	if (!empty($fetchStatement) && is_array($fetchStatement)) {
		foreach ($fetchStatement as $eachStatement) {
			$fetchStatementDetails = $read->findOn('statement_details', 'statement_id', $eachStatement['id']);
			array_push($statements, $eachStatement['id']);
		}

		if (!empty($fetchStatementDetails) && is_array($fetchStatementDetails)) {
			foreach ($fetchStatementDetails as $eachStatementDetails) {
				array_push($statementDetails, $eachStatementDetails['id']);
			}
		}
	}

	$convertStatement = null;
	$convertStatementDetails = null;

	if (!empty($statements) && !empty($statementDetails)) {
		$convertStatement = rtrim(implode(', ', $statements), ' ');
		$convertStatementDetails = rtrim(implode(', ', $statementDetails), ' ');
	}

	if (is_null($convertStatement) && is_null($convertStatementDetails)) {
		$deleteAccounts = $delete->deleteAll('accounts', $_REQUEST['did']);
		if (!empty($deleteAccounts)) {
			echo $misc->alertNotification('success', 'top', 16, 'income data is deleted successfully');
			echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('income-statement') . "'>";
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'something went wrong..');
		}
	} else {
		$deleteStatementDetails = $delete->deleteMultiple('statement_details', $convertStatementDetails);
		if (!empty($deleteStatementDetails)) {
			$deleteStatement = $delete->deleteMultiple('statement', $convertStatement);
			if (!empty($deleteStatement)) {
				$deleteAccounts = $delete->deleteAll('accounts', $_REQUEST['did']);
				if (!empty($deleteAccounts)) {
					echo $misc->alertNotification('success', 'top', 16, 'income data is deleted successfully');
					echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('income-statement') . "'>";
				} else {
					echo $misc->alertNotification('primary', 'top', 16, 'something went wrong..');
				}
			}
		}
	}
}


/**
 * [Update Data]
 * 
 * Update Form Submission Validation by "TOKEN"
 * Execute Update Query and Flash Confirmation Notification
 */
if (isset($_POST['updateIncome'])) {
	if (strlen($_POST['_token']) === 32) {
		$updateIncomeData = $update->updateAccount($_POST['update_title'], $_POST['update_type'], $_POST['update_id']);

		if ($updateIncomeData > 0) {
			echo $misc->alertNotification('success', 'top', 16, 'Income data is updated successfully');
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'might be already exist or something went wrong..');
		}
	}
}


/**
 * [Create Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Execute Create Query Based on Condition and Flash Confirmation Notification
 */
if (isset($_POST['addNewIncome'])) {
	if (strlen($_POST['_token']) === 32 && !empty($_POST['title'])) {
		$createIncomeCategroy = $create->createAccount($_POST['title'], 'Income', $_POST['status']);
		if (!empty($createIncomeCategroy)) {
			echo $misc->alertNotification('success', 'top', 16, 'a new Income category is added successfully');
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'might be already exists or something went wrong');
		}
	}
}


/**
 * [Read Data]
 * 
 * Fetch All The I
 * [1] Accounts
 */
$fetchIncomeData = $read->findOn('accounts', 'type', '"Income"');

?>


<!-- =+|+= INCOME STATEMENT PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div>
						<button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addIncome">
							<i class="ti-plus"></i> Add New Income
						</button>
						<button type="button" class="btn btn-light waves-light waves-effect" id="refreshWindow">
							<i class="ti-reload"></i> Syncronize Data
						</button>
						<button type="button" class="btn btn-secondary waves-effect waves-light" data-toggle="modal" data-target="#editIncomeCategory">
							<i class="ti-pencil-alt"></i> Edit Income
						</button>
					</div>
					<div class="row pt-3">
						<div class="col-md-2 mt-4">

							<?php
							/**
							 * [Dynamic Tab's]
							 * 
							 * Assign Empty Array to Get Income Category as Tabs
							 * Convert Into Required String Format and Push All The Data
							 * Generate Tabs by PreDefined Component Structure
							 */
							$tabsArray = [];

							if (!empty($fetchIncomeData)) {
								if (is_array($fetchIncomeData)) {
									foreach ($fetchIncomeData as $eachIncome) {
										if (str_word_count($eachIncome['title']) > 1) {
											$convertString = strtolower(str_replace(' ', '_', $eachIncome['title']));
										} else {
											$convertString = strtolower($eachIncome['title']);
										}
										array_push($tabsArray, $convertString);
									}
								}
							}

							$comp->tabsNavigation($tabsArray);
							?>

						</div>
						<div class="col-md-10 pt-2">
							<div class="tab-content" id="v-pills-tabContent">

								<?php
								/**
								 * [Dynamic Accordians Based On Tab]
								 * 
								 * Convert Into Required String Format to Navigate Each Tabs
								 * Read Account Statement Based on Each Category
								 * Generate Dynamic DataTable Based On Each Categories Statement Data
								 */
								if (!empty($fetchIncomeData)) {
									if (is_array($fetchIncomeData)) {
										foreach ($fetchIncomeData as $index => $eachIncome) {
											if (str_word_count($eachIncome['title']) > 1) {
												$convertString = strtolower(str_replace(' ', '_', $eachIncome['title']));
											} else {
												$convertString = strtolower($eachIncome['title']);
											}

											$fetchIncomeStatement = $read->findOn('statement', 'account_id', '"' . $eachIncome['id'] . '"');
								?>

											<div class="tab-pane<?php echo $index == 0 ? ' show active' : ''; ?>" id="<?php echo $convertString; ?>" role="tabpanel" aria-labelledby="<?php echo $eachIncome['title'] . '-tab'; ?>">
												<div class="card-body px-3">
													<div class="inbox-wid">
														<div class="table-responsive">
															<table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
																<thead>
																	<tr>
																		<th>#</th>
																		<th>Date</th>
																		<th>Issuer</th>
																		<th>Approved</th>
																		<th>Net Cost</th>
																		<th>Vat Total</th>
																		<th>Grand Total</th>
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody>

																	<?php
																	/**
																	 * Assign Auto Increment Variable Based on Condition
																	 * Read All The Required Data Such As:
																	 * [1] Approved By
																	 * [2] Net Amount Values
																	 * [3] Vat Amount Values
																	 * [4] Total Amount Values
																	 */
																	if (!empty($fetchIncomeStatement)) {
																		$n = 1;
																		if (is_array($fetchIncomeStatement)) {
																			foreach ($fetchIncomeStatement as $index => $each) {
																				$approved = $read->findOn('admins', 'id', $each['approved']);
																				$getNetAmount = $read->sumTotalOn('statement_details', 'net_amount', 'type', '"Income"', 'statement_id', $each['id']);
																				$getVatAmount = $read->sumTotalOn( 'statement_details', 'vat_amount', 'type', '"Income"', 'statement_id', $each['id']);
																				$getTotalAmount = $read->sumTotalOn('statement_details', 'total_amount', 'type', '"Income"', 'statement_id', $each['id']);

																	?>

																				<tr>
																					<td class="font-weight-bold" style="width: 5%;">
																						<?php echo $n; ?>
																					</td>
																					<td style="width: 19%;">
																						<?php echo $misc->dateOnly($each['date']); ?>
																					</td>
																					<td style="width: 21%;">
																						<?php echo $each['issued_by']; ?>
																					</td>
																					<td style="width: 17%;">
																						<?php echo $approved[0]['admin_role_type']; ?>
																					</td>
																					<td style="width: 11%;">
																						<?php echo $getNetAmount[0]['total']; ?>
																					</td>
																					<td style="width: 11%;">
																						<?php echo $getVatAmount[0]['total']; ?>
																					</td>
																					<td style="width: 11%;">
																						<?php echo $getTotalAmount[0]['total']; ?>
																					</td>
																					<td style="width: 5%;">
																						<button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteTableData" type="button" data-did="<?php echo $each['id']; ?>">
																							<i class="ti-trash"></i>
																						</button>
																					</td>
																				</tr>

																	<?php
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

								<?php
										}
									}
								}
								?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= INCOME STATEMENT PAGE CONTENT [END] =+|+= -->


<!-- =+|+= INCOME ADD MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="addIncome" aria-labelledby="addIncomeModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header mx-3">
				<h5 class="modal-title mt-0">Add New Income</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ion-close-round"></i></span>
				</button>
			</div>
			<div class="modal-body">
				<form class="customFormInput px-2" action="" method="POST">
					<input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
					<div class="form-group">
						<label for=""><strong>Income Title</strong></label>
						<input type="text" class="form-control" required name="title" />
					</div>
					<div class="form-group">
						<label for=""><strong>Income Status</strong></label>
						<select class="custom-select" name="status">
							<option selected disabled>Please Select..</option>
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
					</div>
					<div class="form-group">
						<div class="pt-3">
							<button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="addNewIncome">
								<i class="ion-plus-circled"></i> Confirm &amp; Submit
							</button>
							<button type="button" class="btn btn-light text-primary waves-effect m-l-5 px-4" data-dismiss="modal">
								<i class="ion-close-circled"></i> Close
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= INCOME ADD MODAL CONTENT [END] =+|+= -->


<!-- =+|+= INCOME EDIT MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="editIncomeCategory" aria-labelledby="editIncomeCategoryModal" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header mx-3">
				<h5 class="modal-title mt-0">Edit Income</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ion-close-round"></i></span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-sm table-borderless">
					<tbody>

						<?php
						/**
						 * [Edit Data Table]
						 * 
						 * Assign Auto Increment Variable Based on Condition
						 * To Perform an Specific Update Functionalities Each Row will be Able to Exceute
						 */
						if (!empty($fetchIncomeData) && is_array($fetchIncomeData)) {
							$n = 1;
							foreach ($fetchIncomeData as $each) {
						?>

								<form action="" method="POST">
									<tr>
										<input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>">
										<input type="hidden" name="update_id" value="<?php echo $each['id']; ?>">
										<td style="width: 5%;">
											<button class="btn btn-light btn-sm waves-effect waves-light" type="button">
												<?php echo $n; ?>
											</button>
										</td>
										<td style="width: 48%;">
											<input type="text" class="form-control form-control-sm" name="update_title" value="<?php echo $each['title']; ?>" />
										</td>
										<td style="width: 27%;">
											<select class="custom-select custom-select-sm" name="update_type">
												<option <?php if ($each['status'] == "Active") echo "selected"; ?>>Active</option>
												<option <?php if ($each['status'] == "Inactive") echo "selected"; ?>>Inactive</option>
											</select>
										</td>
										<td style="width: 20%;">
											<div class="d-inline-block">
												<button class="btn btn-info btn-sm waves-effect waves-light" type="submit" name="updateIncome">
													<i class="ti-pencil"></i>
												</button>
												<button class="btn btn-primary btn-sm waves-effect waves-light deleteData" type="button" data-toggle="modal" data-target="#deleteIncome" data-did="<?php echo $each['id']; ?>">
													<i class="ti-trash"></i>
												</button>
											</div>
										</td>
									</tr>
								</form>

						<?php
								$n++;
							}
						}
						?>

					</tbody>
				</table>
				<div class="pt-4  mx-2">
					<button type="button" class="btn btn-dark waves-effect btn-block" data-dismiss="modal">
						<i class="ion-close-circled"></i> Close
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= INCOME EDIT MODAL CONTENT [END] =+|+= -->


<!-- =+|+= DELETE INCOME MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteIncome" aria-labelledby="deleteIncomeModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="card-body pb-1">
					<h4 class="card-title font-18 mt-0 font-weight-normal">
						Do you really want to delete this <span id="getName"></span>?
					</h4>
					<div class="pt-3">
						<a href="" class="btn btn-primary waves-effect waves-light px-4" id="deleteIncomeTabsData">
							<i class="ion-checkmark-circled"></i> Confirm
						</a>
						<button type="button" class="btn btn-light waves-effect m-l-5 px-4" data-dismiss="modal">
							<i class="ion-close-circled"></i> Close
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= DELETE INCOME MODAL CONTENT [END] =+|+= -->


<!-- =+|+= EACH INCOME TABLE DATA DELETE MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirmData" aria-labelledby="deleteConfirmDataModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="card-body pb-1">
					<h4 class="card-title font-18 mt-0 font-weight-normal">
						Do you really want to delete this data?
					</h4>
					<div class="pt-3">
						<button type="button" class="btn btn-primary waves-effect waves-light px-4 confirmDelete">
							<i class="ion-checkmark-circled"></i> Confirm
						</button>
						<button type="button" class="btn btn-light waves-effect m-l-5 px-4" data-dismiss="modal">
							<i class="ion-close-circled"></i> Close
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= EACH INCOME TABLE DATA DELETE MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
	$(document).ready(function() {

		/**
		 * Delete A Specific Tab Panel Data
		 * AJAX Request To Get The Name of Delete Data
		 * Pass The Delete Data Name on the Specific ID
		 * URL Generate to Delete Data
		 */
		$(document).on('click', '.deleteData', function() {
			let id = $(this).data('did');
			$.ajax({
				url: "sync.php",
				type: "POST",
				data: {
					action: "DELETE_DATA",
					deleteFrom: "accounts",
					deleteName: "title",
					did: id
				},
				success: function(data) {
					$("#getName").html(data);
				}
			});
			$('#deleteIncomeTabsData').attr('href', 'income-statement.php?did=' + id);
		});



		/**
		 * Detele Specific Table Row Data Baded On Tabs Data
		 * Delete Confirmation Modal Show to Confirm Again
		 * If Confirmed Then Send an AJAX Request To Get The Name of Delete Data
		 * Auto Page Reload 50 MiliSeconds
		 */
		$(document).on("click", ".deleteTableData", function() {
			let id = $(this).data("did");
			$("#deleteConfirmData").modal("show");

			$(document).on("click", ".confirmDelete", function() {
				$("#deleteConfirmData").modal("hide");
				
				$.ajax({
					url: "sync.php",
					type: "POST",
					data: {
						action: "DELETE_STATEMENT_DATA",
						did: id
					},
					success: function(data) {
						console.log(data);
						if (data == 1) {
							setTimeout(function() {
								location.reload();
							}, 50);
						}
					}
				});
			});
		});
	});
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->