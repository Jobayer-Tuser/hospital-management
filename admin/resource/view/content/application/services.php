<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
 * [3] ComponentController
 * [4] CreateController
 * [5] ReadController
 * [6] UpdateController
 * [7] DeleteController
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
 * Execute Read Query and Get All Products Based on Service ID
 * If Products Found:
 * [1] Assign an Empty Array to Get All Deleted Product ID Through Loop
 * [2] Execute Multiple Delete Query to Delete All Products Data
 * [3] Execute Delete Query On Condition to Delete Service Data
 * [4] Flash Confirmation Notification and Refresh this Page as well
 * Otherwise:
 * [1] Execute Delete Query On Condition to Delete Service Data
 * [2] Flash Confirmation Notification and Refresh this Page as well
 */
if (isset($_REQUEST['did'])) {
	$fetchProductList = $read->findOn('products', 'service_id', $_REQUEST['did']);
	if (!empty($fetchProductList) && is_array($fetchProductList)) {
		$index = [];
		for ($i = 0; $i < count($fetchProductList); $i++) {
			array_push($index, $fetchProductList[$i]['id']);
		}
		$index = rtrim(implode(', ', $index), ', ');
		$deleteProducts = $delete->deleteMultiple('products', $index);
		if (!empty($deleteProducts)) {
			$deleteService = $delete->deleteAll('services', $_REQUEST['did']);
			if ($deleteService > 0) {
				echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('services') . "'>";
				echo $misc->alertNotification('success', 'top', 16, 'service data is deleted successfully');
			} else {
				echo $misc->alertNotification('primary', 'top', 16, 'this might be used in somewhere else');
			}
		}
	} else {
		$deleteService = $delete->deleteAll('services', $_REQUEST['did']);
		if ($deleteService > 0) {
			echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('services') . "'>";
			echo $misc->alertNotification('success', 'top', 16, 'service data is deleted successfully');
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'this might be used in somewhere else');
		}
	}
}



/**
 * [Update Data]
 * 
 * Execute Update Status Query and Flash Confirmation Notification
 * 
 * Update Form Submission Validation by "TOKEN"
 * Execute Update Query Based on File Condition
 * Flash Confirmation Notification and Upload a New Files & Remove Previous Files (if required)
 * 
 */
if (isset($_POST['change_status'])) {
	$changeCurrentStatus = $update->changeStatus('services', 'status', $_POST['current_status'], $_POST['change_id']);
	if ($changeCurrentStatus > 0) {
		echo $misc->alertNotification('success', 'top', 16, 'status is changed successfully');
	} else {
		echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
	}
}


if (isset($_POST['updateService'])) {
	if (strlen($_POST['_token']) === 32) {
		$updateService = $update->updateService($_POST['update_category'], $_POST['update_title'], $_POST['update_status'], $_POST['update_id']);
		if ($updateService > 0) {
			echo $misc->alertNotification('success', 'top', 16, 'service data is updated successfully');
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
		}
	}
}



/**
 * [Create Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Execute Create Query Based on Condition and Flash Confirmation Notification
 */
if (isset($_POST['addService'])) {
	if (strlen($_POST['_token']) === 32) {
		$createService = $create->createService($_POST['category'], $_POST['title'], $_POST['status']);
		if ($createService > 0) {
			echo $misc->alertNotification('success', 'top', 16, 'service data is added successfully');
		} else {
			echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
		}
	}
}



/**
 * [Read Data]
 * 
 * Fetch All Table Data Such As:
 * [1] Categories
 * [2] Servies
 */
$fetchCategories = $read->findOn('categories', 'status', '"Active"', 'type', '"Services"');
$fetchServices = $read->all('services');

?>


<!-- =+|+= SERVICES PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div>
						<button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addService">
							<i class="ti-plus"></i> Add New Services
						</button>
						<button type="button" class="btn btn-light waves-light waves-effect" id="refreshWindow">
							<i class="ti-reload"></i> Syncronize Data
						</button>
					</div>
					<div class="pt-3">
						<table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th scope="col" style="width: 5%;">#</th>
									<th scope="col" style="width: 21%;">Service Title</th>
									<th scope="col" style="width: 16%;">Total Product or Service</th>
									<th scope="col" style="width: 10%;">Category</th>
									<th scope="col" style="width: 10%;">Status</th>
									<th scope="col" style="width: 14%;">Created Data</th>
									<th scope="col" style="width: 14%;">Last Modified</th>
									<th scope="col" style="width: 10%;">Action</th>
								</tr>
							</thead>
							<tbody>

								<?php
								/**
								 * Assign Auto Increment Variable Based On Condition
								 * Fetch Table Data Such As:
								 * [1] Categories
								 */
								if (!empty($fetchServices)) {
									$n = 1;
									if (is_array($fetchServices)) {
										foreach ($fetchServices as $each) {
											$getCategories = $read->findOn('categories', 'id', $each['category_id']);
											$getProducts = $read->findOn('products', 'service_id', $each['id']);

											if(!empty($getProducts) && is_array($getProducts)) {
												$hasProduct = count($getProducts);
											} else {
												$hasProduct = 0;
											}
								?>

											<tr>
												<td class="font-weight-bold">
													<?php echo $n; ?>
												</td>
												<td>
													<?php echo $each['title']; ?>
												</td>
												<td class="font-weight-bold">
													<form action="edit-products" method="POST">
														<input type="hidden" name="id" value="<?php echo $each['id']; ?>">
														<button type="submit" class="btn btn-light btn-sm waves-effect waves-light font-weight-bold" name="editProduct">
															<i class="ti-pencil-alt"></i> Edit Service Details <span class="badge badge-success font-weight-bold ml-2"><?php echo $hasProduct; ?></span>
														</button>
													</form>
												</td>
												<td>
													<?php echo $getCategories[0]['title']; ?>
												</td>
												<td>
													<?php echo $comp->changeStatus($each['id'], $each['status']); ?>
												</td>
												<td>
													<?php echo $misc->dateTime($each['created_at']); ?>
												</td>
												<td>
													<?php
													echo !empty($each['updated_at']) ? $misc->dateTime($each['updated_at']) : '';
													?>
												</td>
												<td>
													<div class="d-inline-block">
														<button type="button" class="btn btn-light btn-sm waves-effect waves-light editData" data-toggle="modal" data-target="#editService" data-eid="<?php echo $each['id']; ?>">
															<i class="ti-pencil"></i>
														</button>
														<button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deleteService" data-did="<?php echo $each['id']; ?>">
															<i class="ti-trash"></i>
														</button>
													</div>
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
	</div>
</div>
<!-- =+|+= SERVICES PAGE CONTENT [END] =+|+= -->


<!-- =+|+= SERVICES ADD MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="addService" aria-labelledby="addServiceModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header mx-3">
				<h5 class="modal-title mt-0">Add New Service</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ion-close-round"></i></span>
				</button>
			</div>
			<div class="modal-body">
				<form class="customFormInput px-2" action="" method="POST" id="serviceForm">
					<input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
					<div class="form-group">
						<label for=""><strong>Service Title</strong></label>
						<input type="text" class="form-control" name="title" />
					</div>
					<div class="form-group">
						<label for=""><strong>Category Name</strong></label>
						<select class="custom-select" name="category">
							<option selected disabled>Please Select..</option>
							<?php
							if (!empty($fetchCategories)) {
								if (is_array($fetchCategories)) {
									foreach ($fetchCategories as $each) {
										echo '<option value="' . $each['id'] . '">' . $each['title'] . '</option>';
									}
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for=""><strong>Service Status</strong></label>
						<select class="custom-select" name="status">
							<option>Please Select..</option>
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
					</div>
					<div class="form-group">
						<div class="pt-3">
							<button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="addService">
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
<!-- =+|+= SERVICES ADD MODAL CONTENT [END] =+|+= -->


<!-- =+|+= EDIT DEPARTMENT MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="editService" aria-labelledby="editServiceModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header mx-3">
				<h5 class="modal-title mt-0">Edit Service</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ion-close-round"></i></span>
				</button>
			</div>
			<div id="updatServiceData">
			</div>
		</div>
	</div>
</div>
<!-- =+|+= EDIT DEPARTMENT MODAL CONTENT [END] =+|+= -->


<!-- =+|+= DELETE CATEGORY MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteService" aria-labelledby="deleteServiceModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="card-body pb-1">
					<h4 class="card-title font-16 mt-0 font-weight-normal">
						Do your really want to delete this <span id="getName" class="font-weight-bold"></span>?
					</h4>
					<div class="pt-3">
						<a href="url" class="btn btn-primary waves-effect waves-light px-4" id="deleteData">
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
<!-- =+|+= DELETE CATEGORY MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
	$(document).ready(function() {

		//Empty Form Submission Prevention 
		$(document).on("submit", "#serviceForm", function(e) {
			let title = $("[name='title']").val();
			let category = $("[name='category']").val();

			if (title !== "" && category !== null) {
				return true
			} else {
				e.preventDefault();
				return false;
			}
		});


		//Form Data Reset on Hide Modal
		$("#addService").on("hidden.bs.modal", function(e) {
			$("#serviceForm").trigger("reset");
		});


		//Edit Modal PopUp and Read All The Stored Values
		$(document).on("click", ".editData", function() {
			let id = $(this).data("eid");

			$.ajax({
				url: "sync.php",
				type: "POST",
				data: {
					action: "EDIT_SERVICE_DATA",
					eid: id
				},
				success: function(data) {
					$("#updatServiceData").html(data);
				}
			});
		});


		//Delete Modal and Get Delete Name
		$(document).on("click", ".deleteData", function(e) {
			let id = $(this).data("did");

			$.ajax({
				url: "sync.php",
				type: "POST",
				data: {
					action: "DELETE_DATA",
					deleteFrom: "services",
					deleteName: "title",
					did: id
				},
				success: function(data) {
					$("#getName").html(data);
				}
			});

			$("#deleteData").attr("href", "services.php?did=" + id);
		});

	});
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->