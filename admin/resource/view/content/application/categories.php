<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
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
 * [Required Variables]
 * 
 * Root Path Where Image File Stored
 * File Name Generate
 * Uploaded File Validation
 */
$path = $GLOBALS['ROOT_APPLICATION'] . 'public/uploads/category/';
$fileName = date("YmdHis") . "_" . @$_FILES['logo']['name'];
$fileValid = $misc->checkImage(@$_FILES['logo']['type'], @$_FILES['logo']['size'], @$_FILES['logo']['error']);



/**
 * [Delete Data]
 * 
 * If Request to delete then read all the data (because of delete previous stored image)
 * Assign Empty Array To Get All The Request Deleted Data ID's
 * Create a anonymous function to call to Execute Category Data Only
 * Anonymous function also perform to delete image file also
 * 
 * Base on Type Condition Get All The Required Services or Departments Data
 * If Data is Found then Push into Empty Arrays
 * 
 * Conditional Query Execute to Get the Category Related Services or Departments Data as well
 * Condition to Check Empty Values and Also Convert Array to String for Multiple Data
 * Finally Execute Delete Queries from Categroy Related Nested Data
 * 
 * Flash Confirmation Notifiction and Refresh the Page
 */

if (isset($_REQUEST['did'])) {
   $fetchCategory = $read->findOn('categories', 'id', $_REQUEST['did']);

   $serviceID = [];
   $productID = [];
   $departmentID = [];
   
   $deleteCategory = function () use ($misc, $delete, $fetchCategory) {
      $onlyCategory = $delete->deleteAll('categories', $_REQUEST['did']);
      if ($onlyCategory > 0) {
         unlink($GLOBALS['DIR'] . $fetchCategory[0]['logo']);
         echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('categories') . "'>";
         echo $misc->alertNotification('success', 'top', 16, 'category data is deleted successfully');
      } else {
         echo $misc->alertNotification('primary', 'top', 16, 'this might be used in somewhere else');
      }
   };

   if ($fetchCategory[0]['type'] === "Services") {
      $fetchServices = $read->findOn('services', 'category_id', $fetchCategory[0]['id']);
      if (!empty($fetchServices) && is_array($fetchServices)) {
         foreach ($fetchServices as $eachService) {
            array_push($serviceID, $eachService['id']);
            $fetchProducts = $read->findOn('products', 'service_id', $eachService['id']);
            if (!empty($fetchProducts) && is_array($fetchProducts)) {
               foreach ($fetchProducts as $eachProduct) {
                  array_push($productID, $eachProduct['id']);
               }
            }
         }
      }
   } elseif ($fetchCategory[0]['type'] === "Department") {
      $getDepartmentsData = $read->findOn('departments', 'category_id', $fetchCategory[0]['id']);
      if (!empty($getDepartmentsData) && is_array($getDepartmentsData)) {
         foreach ($getDepartmentsData as $eachDepartment) {
            array_push($departmentID, $eachDepartment['id']);
         }
      }
   }

   if (!empty($serviceID) && is_array($serviceID)) {
      $deleteServices = rtrim(implode(', ', $serviceID), ', ');
      if (!empty($productID) && is_array($productID)) {
         $deleteProducts = rtrim(implode(', ', $productID), ', ');
         $deleteProducts = $delete->deleteMultiple('products', $deleteProducts);
         if (!empty($deleteProducts)) {
            $deleteServices = $delete->deleteMultiple('services', $deleteServices);
            if (!empty($deleteServices)) {
               $deleteCategory();
            }
         }
      } else {
         $deleteServices = $delete->deleteMultiple('services', $deleteServices);
         if (!empty($deleteServices)) {
            $deleteCategory();
         }
      }
   } elseif (!empty($departmentID) && is_array($departmentID)) {
      $deleteDepartments = rtrim(implode(', ', $departmentID), ', ');
      $deleteDepartments = $delete->deleteMultiple('departments', $deleteDepartments);

      if (!empty($deleteDepartments)) {
         $deleteCategory();
      }
   } else {
      $deleteCategory();
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
 */
if (isset($_POST['change_status'])) {
   $changeCurrentStatus = $update->changeStatus('categories', 'status', $_POST['current_status'], $_POST['change_id']);
   if ($changeCurrentStatus > 0) {
      echo $misc->alertNotification('success', 'top', 16, 'status is changed successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
   }
}


if (isset($_POST['updateCategory'])) {
   if (strlen($_POST['_token']) === 32) {
      $fetchDeletedCategory = $read->findOn('categories', 'id', $_POST['update_id']);
      if ($_FILES['logo']['name']) {
         $updateCategory = $update->updateCategoryInc($_POST['update_title'], $fileName, $path, $_POST['update_status'], $_POST['update_id']);
         if ($updateCategory > 0) {
            move_uploaded_file($_FILES['logo']['tmp_name'], $GLOBALS['CATEGORY_DIR'] . $fileName);
            unlink($GLOBALS['CATEGORY_DIR'] . $fetchDeletedCategory[0]['logo']);
            echo $misc->alertNotification('success', 'top', 16, 'category data is updated successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
         }
      } else {
         $updateCategory = $update->updateCategoryExc($_POST['update_title'], $_POST['update_status'], $_POST['update_id']);
         if ($updateCategory > 0) {
            echo $misc->alertNotification('success', 'top', 16, 'category data is updated successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
         }
      }
   }
}



/**
 * [Create Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Execute Create Query Based on Condition and Flash Confirmation Notification
 */
if (isset($_POST['addCategory'])) {
   if (strlen($_POST['_token']) === 32) {
      $createCategory = $create->createCategory($_POST['title'], $_POST['type'], $fileName, $path . $fileName, $_POST['status']);
      if ($createCategory > 0) {
         move_uploaded_file($_FILES['logo']['tmp_name'], $GLOBALS['DIR'] . $fileName);
         echo $misc->alertNotification('success', 'top', 16, 'category data is added successfully');
      } else {
         echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
      }
   }
}



/**
 * [Read Data]
 */
$fetchCategories = $read->all('categories', true);

?>


<!-- =+|+= CATEGORIES PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div>
                  <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addCategory">
                     <i class="ti-plus"></i> Add New Category
                  </button>
                  <button type="button" class="btn btn-light waves-light waves-effect" id="refreshWindow">
                     <i class="ti-reload"></i> Syncronize Data
                  </button>
               </div>
               <div class="pt-3">
                  <table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th style="width: 5%;">#</th>
                           <th style="width: 16%;">Category Title</th>
                           <th style="width: 8%;">Type</th>
                           <th style="width: 8%;">Logo</th>
                           <th style="width: 17%;">Total Service or Dept</th>
                           <th style="width: 10%;">Status</th>
                           <th style="width: 14%;">Created Date</th>
                           <th style="width: 14%;">Last Modified</th>
                           <th style="width: 8%;">Action</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        /**
                         * Assign Auto Increment Variable Based On Condition
                         * Count Service and Department Total
                         */
                        if (!empty($fetchCategories)) {
                           $n = 1;
                           if (is_array($fetchCategories)) {
                              foreach ($fetchCategories as $each) {

                                 if ($each['type'] == "Services") {
                                    $getEachServicesData = $read->findOn('services', 'category_id', $each['id']);
                                    if (is_array($getEachServicesData)) {
                                       $serviceTotal = count($getEachServicesData);
                                    } else {
                                       $serviceTotal = 0;
                                    }
                                    $eachTotal = 'Total <span class="badge badge-success font-weight-bold mx-1">' . $serviceTotal . '</span> Services';
                                 } elseif ($each['type'] == "Department") {
                                    $getEachDepartmentsData = $read->findOn('departments', 'category_id', $each['id']);
                                    if (is_array($getEachDepartmentsData)) {
                                       $departmentTotal = count($getEachDepartmentsData);
                                    } else {
                                       $departmentTotal = 0;
                                    }
                                    $eachTotal = 'Total <span class="badge badge-success font-weight-bold mx-1">' . $departmentTotal . '</span> Departments';
                                 }

                        ?>

                                 <tr>
                                    <td class="font-weight-bold">
                                       <?php echo $n; ?>
                                    </td>
                                    <td>
                                       <?php echo $each['title']; ?>
                                    </td>
                                    <td>
                                       <strong><?php echo $each['type']; ?></strong>
                                    </td>
                                    <td>
                                       <img src="<?php echo $GLOBALS['CATEGORY_DIR'] . $each['logo']; ?>" alt="" class="thumb-sm rounded-circle mr-2" />
                                    </td>
                                    <td>
                                       <button type="button" class="btn btn-light btn-sm waves-effect waves-light font-weight-bold text-left">
                                          <i class="ti-package"></i> <?php echo $eachTotal ?>
                                       </button>
                                    </td>
                                    <td>
                                       <?php echo $comp->changeStatus($each['id'], $each['status']); ?>
                                    </td>
                                    <td>
                                       <?php echo $misc->dateTime($each['created_at']); ?>
                                    </td>
                                    <td>
                                       <?php echo $misc->dateTime($each['updated_at']); ?>
                                    </td>
                                    <td>
                                       <div class="d-inline-block">
                                          <button type="button" class="btn btn-light btn-sm waves-effect waves-light editData" data-toggle="modal" data-target="#editCategory" data-eid="<?php echo $each['id']; ?>">
                                             <i class="ti-pencil"></i>
                                          </button>
                                          <button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deleteCategory" data-did="<?php echo $each['id']; ?>">
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
<!-- =+|+= CATEGORIES PAGE CONTENT [END] =+|+= -->


<!-- =+|+= ADD CATEGORY MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="addCategory" aria-labelledby="addCategoryModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header mx-3">
            <h5 class="modal-title mt-0">Add New Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ion-close-round"></i></span>
            </button>
         </div>
         <div class="modal-body">
            <form class="customFormInput px-2" action="" method="POST" enctype="multipart/form-data" id="categoryForm">
               <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
               <div class="form-group">
                  <label for=""><strong>Category Title</strong></label>
                  <input type="text" class="form-control" name="title" />
               </div>
               <div class="form-group">
                  <label for=""><strong>Type of Category</strong></label>
                  <div class="custom-control custom-radio">
                     <input type="radio" id="customRadio1" name="type" value="Services" class="custom-control-input" checked />
                     <label class="custom-control-label" for="customRadio1">
                        All kind of services except doctor department
                     </label>
                  </div>
                  <div class="custom-control custom-radio">
                     <input type="radio" id="customRadio2" name="type" value="Department" class="custom-control-input" />
                     <label class="custom-control-label" for="customRadio2">
                        Or only for doctor departments
                     </label>
                  </div>
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Status</strong></label>
                  <select class="custom-select" name="status">
                     <option>Please Select..</option>
                     <option value="Active">Active</option>
                     <option value="Inactive">Inactive</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Icon or Logo</strong></label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <button class="btn btn-secondary" type="button" id="uploadIcon">
                           <i class="mdi mdi-cloud-upload"></i>
                        </button>
                     </div>
                     <div class="custom-file">
                        <input type="file" class="custom-file-input imageFile" name="logo" aria-describedby="uploadIcon" />
                        <label class="custom-file-label fileName" for="avatar">Choose file</label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="pt-3">
                     <button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="addCategory">
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
<!-- =+|+= ADD CATEGORY MODAL CONTENT [END] =+|+= -->


<!-- =+|+= EDIT CATEGORY MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="editCategory" aria-labelledby="editCategoryModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header mx-3">
            <h5 class="modal-title mt-0">Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ion-close-round"></i></span>
            </button>
         </div>
         <div id="updateCategoryData">
            <!-- Editable Data Will Be Appear Here -->
         </div>
      </div>
   </div>
</div>
<!-- =+|+= EDIT CATEGORY MODAL CONTENT [END] =+|+= -->


<!-- =+|+= DELETE CATEGORY MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteCategory" aria-labelledby="deleteCategoryModal" aria-hidden="true">
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
      $(document).on("submit", "#categoryForm", function(e) {
         let title = $("[name='title']").val();
         let logo = $("[name='logo']").val();

         if (title !== "" && logo !== "") {
            return true
         } else {
            e.preventDefault();
            return false;
         }
      });


      //Form Data Reset on Hide
      $("#addCategory").on("hidden.bs.modal", function(e) {
         $("#categoryForm").trigger("reset");
      });


      //Edit Modal PopUp and Read All The Stored Values
      $(document).on("click", ".editData", function() {
         let id = $(this).data("eid");

         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "EDIT_CATEGORY_DATA",
               eid: id
            },
            success: function(data) {
               $("#updateCategoryData").html(data);
            }
         });
      });


      //Delete Modal Pop Up and Get Deleted Data Name
      $(document).on("click", ".deleteData", function(e) {
         let id = $(this).data("did");

         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "DELETE_DATA",
               deleteFrom: "categories",
               deleteName: "title",
               did: id
            },
            success: function(data) {
               console.log(data);
               $("#getName").html(data);
            }
         });

         $("#deleteData").attr("href", "categories.php?did=" + id);
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->