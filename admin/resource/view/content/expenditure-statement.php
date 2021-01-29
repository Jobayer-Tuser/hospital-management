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
			echo $misc->alertNotification('success', 'top', 16, 'expenditure data is deleted successfully');
			echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('expenditure-statement') . "'>";
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
					echo $misc->alertNotification('success', 'top', 16, 'expenditure data is deleted successfully');
					echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('expenditure-statement') . "'>";
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
if (isset($_POST['updateExpenditure'])) {
	if (strlen($_POST['_token']) === 32) {
		$updateExpenditureData = $update->updateAccount($_POST['update_title'], $_POST['update_type'], $_POST['update_id']);

		if ($updateExpenditureData > 0) {
			echo $misc->alertNotification('success', 'top', 16, 'expenditure data is updated successfully');
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
if (isset($_POST['addNewExpenditure'])) {
	if (strlen($_POST['_token']) === 32 && !empty($_POST['title'])) {
		$createExpenditureCategroy = $create->createAccount($_POST['title'], 'Expenditure', $_POST['status']);
		if (!empty($createExpenditureCategroy)) {
			echo $misc->alertNotification('success', 'top', 16, 'a new expenditure category is added successfully');
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'might be already exists or something went wrong');
		}
	}
}


/**
 * [Read Data]
 * 
 * Fetch All The Required Table Data Such as:
 * [1] Accounts
 * [2] Statement
 */
$fetchExpenditureData = $read->findOn('accounts', 'type', '"Expenditure"');
$fetchExpenditureStatement = $read->findOn('statement', 'type', '"Expenditure"');

?>


<!-- =+|+= Expenditure Statement Page Content -Start- =+|+= -->
<div class="page-content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div>
						<button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal"
							data-target="#addExpenditure">
							<i class="ti-plus"></i> Add New Expenditure
						</button>
						<button type="button" class="btn btn-light waves-light waves-effect" id="refreshWindow">
							<i class="ti-reload"></i> Syncronize Data
						</button>
						<button type="button" class="btn btn-secondary waves-effect waves-light" data-toggle="modal"
							data-target="#editExpenditureCategory">
							<i class="ti-pencil-alt"></i> Edit Expenditure
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

							if (!empty($fetchExpenditureData)) {
								if (is_array($fetchExpenditureData)) {
									foreach ($fetchExpenditureData as $eachExpenditure) {
										if (str_word_count($eachExpenditure['title']) > 1) {
											$convertString = strtolower(str_replace(' ', '_', $eachExpenditure['title']));
										} else {
											$convertString = strtolower($eachExpenditure['title']);
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
								if (!empty($fetchExpenditureData)) {
									if (is_array($fetchExpenditureData)) {
										foreach ($fetchExpenditureData as $index => $eachExpenditure) {
											if (str_word_count($eachExpenditure['title']) > 1) {
												$convertString = strtolower(str_replace(' ', '_', $eachExpenditure['title']));
											} else {
												$convertString = strtolower($eachExpenditure['title']);
											}

											$fetchExpenditureStatement = $read->findOn('statement', 'account_id', '"' . $eachExpenditure['id'] . '"');
								?>

											<div class="tab-pane<?php echo $index == 0 ? ' show active' : ''; ?>" id="<?php echo $convertString; ?>"
												role="tabpanel" aria-labelledby="<?php echo $eachExpenditure['title'] . '-tab'; ?>">
												<div class="card-body px-3">
													<div class="inbox-wid">
														<div class="table-responsive">
															<table class="table dt-responsive nowrap datatable"
																style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
																	if (!empty($fetchExpenditureStatement)) {
																		$n = 1;
																		if (is_array($fetchExpenditureStatement)) {
																			foreach ($fetchExpenditureStatement as $index => $each) {
																				$approved = $read->findOn('admins', 'id', $each['approved']);
																				$getNetAmount = $read->sumTotalOn('statement_details', 'net_amount', 'type', '"Expenditure"', 'statement_id', $each['id']);
																				$getVatAmount = $read->sumTotalOn( 'statement_details', 'vat_amount', 'type', '"Expenditure"', 'statement_id', $each['id']);
																				$getTotalAmount = $read->sumTotalOn('statement_details', 'total_amount', 'type', '"Expenditure"', 'statement_id', $each['id']);
																	?>

																				<tr>
																					<td class="font-weight-bold" style="width: 5%;"><?php echo $n; ?></td>
																					<td style="width: 19%;"><?php echo $misc->dateOnly($each['date']); ?></td>
																					<td style="width: 21%;"><?php echo $each['issued_by']; ?></td>
																					<td style="width: 17%;"><?php echo $approved[0]['admin_role_type']; ?></td>
																					<td style="width: 11%;"><?php echo $getNetAmount[0]['total']; ?></td>
																					<td style="width: 11%;"><?php echo $getVatAmount[0]['total']; ?></td>
																					<td style="width: 11%;"><?php echo $getTotalAmount[0]['total']; ?></td>
																					<td style="width: 5%;">
																						<button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteTableData"
																							type="button" data-did="<?php echo $each['id']; ?>">
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
<!-- =+|+= Expenditure Statement Page Content -End- =+|+= -->

<!-- =+|+= Expenditure Category Add Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="addExpenditure" aria-labelledby="addExpenditureModal"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header mx-3">
				<h5 class="modal-title mt-0">Add New Expenditure</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ion-close-round"></i></span>
				</button>
			</div>
			<div class="modal-body">
				<form class="customFormInput px-2" action="" method="POST">
					<input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
					<div class="form-group">
						<label for=""><strong>Expenditure Title</strong></label>
						<input type="text" class="form-control" required name="title" />
					</div>
					<div class="form-group">
						<label for=""><strong>Expenditure Status</strong></label>
						<select class="custom-select" name="status">
							<option selected disabled>Please Select..</option>
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
					</div>
					<div class="form-group">
						<div class="pt-3">
							<button type="submit" class="btn btn-light text-success waves-effect waves-light px-4"
								name="addNewExpenditure">
								<i class="ion-plus-circled"></i> Confirm &amp; Submit
							</button>
							<button type="button" class="btn btn-light text-primary waves-effect m-l-5 px-4"
								data-dismiss="modal">
								<i class="ion-close-circled"></i> Close
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- =+|+= Expenditure Category Add Modal Content -End- =+|+= -->

<!-- =+|+= Expenditure Category Edit Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="editExpenditureCategory"
	aria-labelledby="editExpenditureCategoryModal" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header mx-3">
				<h5 class="modal-title mt-0">Edit Expenditure</h5>
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
						if (!empty($fetchExpenditureData) && is_array($fetchExpenditureData)) {
							$n = 1;
							foreach ($fetchExpenditureData as $each) {
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
											<input type="text" class="form-control form-control-sm" name="update_title"
												value="<?php echo $each['title']; ?>" />
										</td>
										<td style="width: 27%;">
											<select class="custom-select custom-select-sm" name="update_type">
												<option <?php if ($each['status'] == "Active") echo "selected"; ?>>Active</option>
												<option <?php if ($each['status'] == "Inactive") echo "selected"; ?>>Inactive</option>
											</select>
										</td>
										<td style="width: 20%;">
											<div class="d-inline-block">
												<button class="btn btn-info btn-sm waves-effect waves-light" type="submit" name="updateExpenditure">
													<i class="ti-pencil"></i>
												</button>
												<button class="btn btn-primary btn-sm waves-effect waves-light deleteData" type="button"
													data-toggle="modal" data-target="#deleteExpenditure" data-did="<?php echo $each['id']; ?>">
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
<!-- =+|+= Expenditure Category Add Modal Content -End- =+|+= -->

<!-- =+|+= Expenditure Category Delete Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteExpenditure" aria-labelledby="deleteExpenditureModal"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="card-body pb-1">
					<h4 class="card-title font-18 mt-0 font-weight-normal">
						Do you really want to delete this <span id="getName"></span>?
					</h4>
					<div class="pt-3">
						<a href="" class="btn btn-primary waves-effect waves-light px-4" id="deleteExpenditureTabsData">
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
<!-- =+|+= Expenditure Category Delete Modal Content -End- =+|+= -->

<!-- =+|+= Each Expenditure Table Data Delete Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirmData" aria-labelledby="deleteConfirmDataModal"
	aria-hidden="true">
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
<!-- =+|+= Each Expenditure Table Data Delete Modal Content -End- =+|+= -->

<!-- =+|+= JavaScript Content -Start- =+|+= -->
<script type="text/javascript">
	$(document).ready(function() {

		/**
		 * Delete A Specific Tab Panel Data
		 * AJAX Request To Get The Name of Delete Data
		 * Pass The Delete Data Name on the Specific ID
		 * URL Generate to Delete Data
		 */
		$(document).on("click", ".deleteData", function() {
			let id = $(this).data("did");
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
			$("#deleteExpenditureTabsData").attr("href", "expenditure-statement.php?did=" + id);
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
<!-- =+|+= JavaScript Content -End- =+|+= -->