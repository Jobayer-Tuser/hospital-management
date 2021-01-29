<?php

/**
 * [Object Defined] 
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ReadController
 * [3] DeleteController
 * [4] UpdateController
 */
$misc = new MiscellaneousController;
$date = new DateController;
$create = new CreateController;
$read = new ReadController;
$delete = new DeleteController;


/**
 * [Delete Data]
 * 
 * Execute Delete Query and Flash Confirmation Notification
 */
if (isset($_REQUEST['did'])) {
   $deleteAppointmentRequest = $delete->deleteAll('appointment_request', $_REQUEST['did']);
   if ($deleteAppointmentRequest > 0) {
      echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('make-appointment') . "'>";
      echo $misc->alertNotification('success', 'top', 16, 'appointment data is deleted successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
   }
}


/**
 * [Create and Delete Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Convert Date and Time inot SQL Format
 * Execute Create Query and Also Execute Delete Query Based on Condition
 * Flash Confirmation Notification
 */
if (isset($_POST['confirmAppointment'])) {
   if (strlen($_POST['_token']) === 32) {
      if (!empty($_POST['dateTime'])) {
         $dateTime = $_POST['dateTime'];
      } else {
         $dateTime = $_POST['updateTime'];
      }
      $createAppointment = $create->createAppointment(
         $_POST['user_id'], 
         $_POST['user'],  
         $_POST['phone'], 
         $_POST['email'], 
         $date->sqlDateTime($dateTime), 
         $_POST['doctor'], 
         $_POST['department'], 
         $date->sqlDate($dateTime)
      );
      if ($createAppointment > 0) {
         $deleteAppointmentRequest = $delete->deleteAll('appointment_request', $_POST['id']);
         if (!empty($deleteAppointmentRequest)) {
            echo $misc->alertNotification('success', 'top', 16, 'appointment is confirmed successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
         }
      } else {
         echo $misc->alertNotification('primary', 'top', 16, 'unable to confirmed appointment');
      }
   }
}


/**
 * [Read Data]
 * 
 * Fetch All The Appointment Request Data
 */
$fetchAppointmentRequest = $read->all('appointment_request', true);

?>

<style>
   /* Define Required Styles (for this page only) */
   .custom-select-sm {
      padding-top: 5px;
   }
</style>

<!-- =+|+= Make Appointment Page Content -Start- =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 pt-4">
                     <div class="table-responsive">
                        <table class="table dt-responsive nowrap datatable"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                           <thead>
                              <tr>
                                 <th scope="col" style="width: 1%;">#</th>
                                 <th scope="col" style="width: 14%;">User Name</th>
                                 <th scope="col" style="width: 12%;">Phone No</th>
                                 <th scope="col" style="width: 13%;">Email</th>
                                 <th scope="col" style="width: 16%;">Date & Time</th>
                                 <th scope="col" style="width: 23%;">Doctor</th>
                                 <th scope="col" style="width: 12%;">Department</th>
                                 <th scope="col" style="width: 7%;">Action</th>
                              </tr>
                           </thead>
                           <tbody>

                              <?php
                              /**
                               * Assign a Variable for Auto Increment Based on Condition
                               * Get Required Table Data Such as:
                               * [1] Users
                               * [2] Doctors
                               * [3] Department
                               */
                              if (!empty($fetchAppointmentRequest) && is_array($fetchAppointmentRequest)) {
                                 $n = 1;
                                 foreach ($fetchAppointmentRequest as $eachRequest) {
                                    $fetchUsers = $read->findOn('users', 'id', $eachRequest['user_id']);
                                    $fetchDoctors = $read->findOn('doctors', 'id', $eachRequest['doctor_id']);
                                    $getDepartment = $read->findOn('departments', 'id', $fetchDoctors[0]['department_id']);
                              ?>

                                    <tr>
                                       <form action="" method="POST">
                                          <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                                          <input type="hidden" name="id" value="<?php echo $eachRequest['id']; ?>" />
                                          <input type="hidden" name="user_id"
                                             value="<?php echo $fetchUsers[0]['user_id']; ?>" />
                                          <td class="font-weight-bold"><?php echo $n; ?></td>
                                          <td>
                                             <input type="text" name="user" class="form-control form-control-sm"
                                                value="<?php echo $fetchUsers[0]['full_name']; ?>" />
                                          </td>
                                          <td>
                                             <input type="text" name="phone" class="form-control form-control-sm"
                                                value="<?php echo $fetchUsers[0]['mobile']; ?>" />
                                          </td>
                                          <td>
                                             <input type="text" name="email" class="form-control form-control-sm"
                                                value="<?php echo $fetchUsers[0]['email']; ?>" />
                                          </td>
                                          <td>
                                             <input class="form-control datepicker-here" type="text" name="dateTime"
                                                placeholder="<?php echo @$date->revertDate($eachRequest['scheduled_at']); ?>"
                                                data-language='en' data-timepicker="true" />
                                             <input type="hidden" name="updateTime"
                                                value="<?php echo @$date->revertDate($eachRequest['date_time']); ?>">
                                          </td>
                                          <td>
                                             <input type="text" name="doctor" class="form-control form-control-sm"
                                                value="<?php echo $fetchDoctors[0]['full_name']; ?>" />
                                          </td>
                                          <td>
                                             <input type="text" name="department" class="form-control form-control-sm"
                                                value="<?php echo $getDepartment[0]['title']; ?>" />
                                          </td>
                                          <td>
                                             <div class="d-inline">
                                                <button class="btn btn-light btn-sm waves-effect waves-light"
                                                   type="submit" name="confirmAppointment">
                                                   <i class="ti-pencil-alt"></i>
                                                </button>
                                                <button type="button"
                                                   class="btn btn-danger btn-sm waves-effect waves-light deleteData"
                                                   data-toggle="modal" data-target="#deletePricing"
                                                   data-did="<?php echo $eachRequest['id']; ?>">
                                                   <i class="ti-trash"></i>
                                                </button>
                                             </div>
                                          </td>
                                       </form>
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
   </div>
</div>
<!-- =+|+= Make Appointment Page Content -End- =+|+= -->

<!-- =+|+= Appointment Delete Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deletePricing" aria-labelledby="deletePricingModal"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="card-body pb-1">
               <h4 class="card-title font-16 mt-0 font-weight-normal">
                  Do your really want to delete this appointment request?
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
<!-- =+|+= Appointment Delete Modal Content -End- =+|+= -->

<!-- =+|+= JavaScript Content -Start- =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {
      $(document).on("click", ".deleteData", function(e) {
         let id = $(this).data("did");
         $("#deleteData").attr("href", "make-appointment?did=" + id);
      });
   });
</script>
<!-- =+|+= JavaScript Content -End- =+|+= -->