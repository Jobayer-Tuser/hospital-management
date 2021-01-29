<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
 * [3] Component Controller
 * [4] ReadController
 * [5] UpdateController
 * [6] DeleteController
 */
$misc = new MiscellaneousController;
$comp = new ComponentController;
$read = new ReadController;
$update = new UpdateController;
$delete = new DeleteController;



/**
 * [Delete Data]
 * 
 * If Request to delete then read all the data (because of delete previous stored image)
 * Execute Delete Query and Flash Confirmation Notification
 */
if (isset($_REQUEST['did'])) {
   $getDoctorData = $read->findOn('doctors', 'id', $_REQUEST['did']);
   $deleteDoctorData = $delete->deleteAll('doctors', $_REQUEST['did']);

   if ($deleteDoctorData > 0) {
      unlink($GLOBALS['DOCTORS_DIR'] . $getDoctorData[0]['avatar']);
      echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('doctors') . "'>";
      echo $misc->alertNotification('success', 'top', 16, 'doctor data is deleted successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'this might be used in somewhere else');
   }
}



/**
 * [Update Data]
 * 
 * Execute Update Status Query and Flash Confirmation Notification
 */
if (isset($_POST['change_status'])) {
   $changeCurrentStatus = $update->changeStatus('doctors', 'status', $_POST['current_status'], $_POST['change_id']);
   if ($changeCurrentStatus > 0) {
      echo $misc->alertNotification('success', 'top', 16, 'status is changed successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
   }
}



/**
 * [Read Data]
 */
$fetchDoctors = $read->all('doctors');

?>

<!-- =+|+= DOCTOR PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="pt-3">
                  <table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th scope="col" style="width: 5%;">#</th>
                           <th scope="col" style="width: 17%;">Name</th>
                           <th scope="col" style="width: 15%;">Desination</th>
                           <th scope="col" style="width: 41%;">Organization</th>
                           <th scope="col" style="width: 8%;">Status</th>
                           <th scope="col" style="width: 14%;">Action</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        if (!empty($fetchDoctors)) {
                           $n = 1;
                           if (is_array($fetchDoctors)) {
                              foreach ($fetchDoctors as $each) {
                        ?>

                                 <tr>
                                    <td class="font-weight-bold">
                                       <?php echo $n; ?>
                                    </td>
                                    <td>
                                       <?php echo $each['full_name']; ?>
                                    </td>
                                    <td>
                                       <?php echo $each['designation']; ?>
                                    </td>
                                    <td>
                                       <?php echo $each['organization']; ?>
                                    </td>
                                    <td>
                                       <?php echo $comp->changeStatus($each['id'], $each['status']); ?>
                                    </td>
                                    <td>
                                       <div class="d-inline-flex">
                                       <button type="button" class="btn btn-success btn-sm waves-effect waves-light profile" data-toggle="modal" data-target="#doctorProfile" data-id="<?php echo $each['id']; ?>">
                                          <i class="ti-eye"></i>
                                       </button>
                                       <form action="edit-doctor" method="POST">
														<input type="hidden" name="id" value="<?php echo $each['id']; ?>">
														<button type="submit" class="btn btn-white btn-sm waves-effect waves-light mx-1" name="editDoctorData">
															<i class="ti-pencil-alt"></i>
														</button>
													</form>
                                       <button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deleteDoctor" data-did="<?php echo $each['id']; ?>">
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
<!-- =+|+= DOCTOR PAGE CONTENT [END] =+|+= -->


<!-- =+|+= DOCTOR PROFILE MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="doctorProfile" aria-labelledby="doctorProfileModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="card mb-0" id="doctorDetailsCard">
               <!-- Doctor Profile Details -->
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= DOCTOR PROFILE MODAL CONTENT [END] =+|+= -->


<!-- =+|+= DELETE DOCTOR DATA MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteDoctor" aria-labelledby="deleteDoctorModal" aria-hidden="true">
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
<!-- =+|+= DELETE DOCTOR DATA MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {
      $(document).on("click", ".profile", function() {
         let doctorID = $(this).data("id");

         if (doctorID !== "") {
            $.ajax({
               url: "sync.php",
               type: "POST",
               data: {
                  action: "GET_DOCTOR_PROFILE",
                  id: doctorID
               },
               success: function(data) {
                  console.log(data);
                  $("#doctorDetailsCard").html(data);
               }
            });
         }
      });


      //Delete Modal and Get Delete Name
      $(document).on("click", ".deleteData", function(e) {
         let id = $(this).data("did");

         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "DELETE_DATA",
               deleteFrom: "doctors",
               deleteName: "full_name",
               did: id
            },
            success: function(data) {
               console.log(data);
               $("#getName").html(data);
            }
         });

         $("#deleteData").attr("href", "doctors.php?did=" + id);
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->