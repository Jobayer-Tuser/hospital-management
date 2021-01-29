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
 * [Delete Data]
 * 
 * Fetch All The Doctors Data Based on Request to Deleted Department
 * Assign Empty Arrays and Get the Deleted Doctors ID and Image File Name as well
 * Delete Doctors Data and Remove all The Image from Stored Directory
 * Execute Delete Query and Flash Confirmation Notifiction Based on Action
 */
if (isset($_REQUEST['did'])) {
   $fetchDoctor = $read->findOn('doctors', 'department_id', $_REQUEST['did']);
   $doctorsID = [];
   $imageFiles = [];
   if (!empty($fetchDoctor) && is_array($fetchDoctor)) {
      foreach ($fetchDoctor as $eachDoctor) {
         array_push($doctorsID, $eachDoctor['id']);
         array_push($imageFiles, $eachDoctor['avatar']);
      }
      if (!empty($doctorsID) && is_array($doctorsID)) {
         for ($i = 0; $i < count($doctorsID); $i++) {
            $deleteDoctorsData = $delete->deleteAll('doctors', $doctorsID[$i]);
            unlink($GLOBALS['DOCTORS_DIR'] . $imageFiles[$i]);
         }
         if (!empty($deleteDoctorsData)) {
            $deleteDepartment = $delete->deleteAll('departments', $_REQUEST['did']);
            if ($deleteDepartment > 0) {
               echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('departments') . "'>";
               echo $misc->alertNotification('success', 'top', 16, 'department data is deleted successfully');
            } else {
               echo $misc->alertNotification('primary', 'top', 16, 'this might be used in somewhere else');
            }
         }
      }
   } else {
      $deleteDepartment = $delete->deleteAll('departments', $_REQUEST['did']);
      if ($deleteDepartment > 0) {
         echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('departments') . "'>";
         echo $misc->alertNotification('success', 'top', 16, 'department data is deleted successfully');
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
   $changeCurrentStatus = $update->changeStatus('departments', 'status', $_POST['current_status'], $_POST['change_id']);
   if ($changeCurrentStatus > 0) {
      echo $misc->alertNotification('success', 'top', 16, 'status is changed successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
   }
}


if (isset($_POST['updateDepartment'])) {
   if (strlen($_POST['_token']) === 32) {
      $updateDepartment = $update->updateDepartment($_POST['update_category'], $_POST['update_title'], $_POST['update_status'], $_POST['update_id']);
      if ($updateDepartment > 0) {
         echo $misc->alertNotification('success', 'top', 16, 'department data is updated successfully');
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
if (isset($_POST['addDepartment'])) {
   if (strlen($_POST['_token']) === 32) {
      if (!empty($_POST['category'])) {
         $createDepartment = $create->createDepartment($_POST['category'], $_POST['title'], $_POST['status']);
         if ($createDepartment > 0) {
            echo $misc->alertNotification('success', 'top', 16, 'department data is added successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
         }
      }
   }
}



/**
 * [Read Data]
 * 
 * Fetch All Table Data Such As:
 * [1] Categories
 * [2] Departments
 */
$fetchCategories = $read->findOn('categories', 'status', '"Active"', 'type', '"Department"');
$fetchDepartments = $read->all('departments', true);

?>


<!-- =+|+= DEPARTMENTS PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div>
                  <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addDepartment">
                     <i class="ti-plus"></i> Add New Department
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
                           <th scope="col" style="width: 21%;">Department Title</th>
                           <th scope="col" style="width: 16%;">Total Doctor</th>
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
                        if (!empty($fetchDepartments)) {
                           $n = 1;
                           if (is_array($fetchDepartments)) {
                              foreach ($fetchDepartments as $each) {
                                 $getCategory = $read->findOn('categories', 'id', $each['category_id']);
                                 $getDoctors = $read->findOn('doctors', 'department_id', $each['id']);
                                 
											if(!empty($getDoctors) && is_array($getDoctors)) {
												$hasDoctor = count($getDoctors);
											} else {
												$hasDoctor = 0;
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
                                       <button type="button" class="btn btn-light btn-sm waves-effect waves-light font-weight-bold">
                                          <i class="ti-support"></i> &nbsp;Total Doctor<span class="badge badge-success font-weight-bold ml-2"><?php echo $hasDoctor; ?> </span>
                                       </button>
                                    </td>
                                    <td>
                                       <?php echo $getCategory[0]['title']; ?>
                                    </td>
                                    <td>
                                       <?php echo $comp->changeStatus($each['id'], $each['status']); ?>
                                    </td>
                                    <td>
                                       <?php echo $misc->dateTime($each['created_at']); ?>
                                    </td>
                                    <td>
                                       <?php echo !empty($each['updated_at']) ? $misc->dateTime($each['updated_at']) : ''; ?>
                                    </td>
                                    <td>
                                       <div class="d-inline-block">
                                          <button type="button" class="btn btn-light btn-sm waves-effect waves-light editData" data-toggle="modal" data-target="#editDepartment" data-eid="<?php echo $each['id']; ?>">
                                             <i class="ti-pencil"></i>
                                          </button>
                                          <button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deleteDepartment" data-did="<?php echo $each['id']; ?>">
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
<!-- =+|+= DEPARTMENTS PAGE CONTENT [END] =+|+= -->


<!-- =+|+= ADD DEPARTMENT MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="addDepartment" aria-labelledby="addDepartmentModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header mx-3">
            <h5 class="modal-title mt-0">Add New Department</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ion-close-round"></i></span>
            </button>
         </div>
         <div class="modal-body">
            <form class="customFormInput px-2" action="" method="POST" id="departmentForm">
               <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
               <div class="form-group">
                  <label for=""><strong>Department Title</strong></label>
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
                  <label for=""><strong>Department Status</strong></label>
                  <select class="custom-select" name="status">
                     <option>Please Select..</option>
                     <option value="Active">Active</option>
                     <option value="Inactive">Inactive</option>
                  </select>
               </div>
               <div class="form-group">
                  <div class="pt-3">
                     <button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="addDepartment">
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
<!-- =+|+= ADD DEPARTMENT MODAL CONTENT [END] =+|+= -->


<!-- =+|+= EDIT DEPARTMENT MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="editDepartment" aria-labelledby="editDepartmentModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header mx-3">
            <h5 class="modal-title mt-0">Edit Department</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ion-close-round"></i></span>
            </button>
         </div>
         <div id="updateDepartmentData">
            <!-- Editable Data Will Be Appear Here -->
         </div>
      </div>
   </div>
</div>
<!-- =+|+= EDIT DEPARTMENT MODAL CONTENT [END] =+|+= -->


<!-- =+|+= DELETE DEPARTMENT MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteDepartment" aria-labelledby="deleteDepartmentModal" aria-hidden="true">
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
<!-- =+|+= DELETE DEPARTMENT MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {

      //Empty Form Submission Prevention
      $(document).on("submit", "#departmentForm", function(e) {
         let title = $("[name='title']").val();
         let category = $("[name='category']").val();

         if (title !== "" && category !== null) {
            return true
         } else {
            e.preventDefault();
            return false;
         }
      });


      //Form Data Reset on Hide
      $("#addDepartment").on("hidden.bs.modal", function(e) {
         $("#departmentForm").trigger("reset");
      });


      //Edit Modal PopUp and Read All The Stored Values
      $(document).on("click", ".editData", function() {
         let id = $(this).data("eid");

         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "EDIT_DEPARTMENT_DATA",
               eid: id
            },
            success: function(data) {
               $("#updateDepartmentData").html(data);
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
               deleteFrom: "departments",
               deleteName: "title",
               did: id
            },
            success: function(data) {
               $("#getName").html(data);
            }
         });

         $("#deleteData").attr("href", "departments.php?did=" + id);
      });

   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->