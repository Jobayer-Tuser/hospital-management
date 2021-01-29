<?php

/**
 * ----------------------------------------
 * Object Defined
 * ----------------------------------------
 * 1. Miscellaneous Controller
 * 2. Component Controller
 * 3. Date Controller
 * 4. Read Controller
 * 5. Update Controller
 * 6. Delete Controller
 */
$misc = new MiscellaneousController;
$comp = new ComponentController;
$date = new DateController;
$read = new ReadController;
$update = new UpdateController;
$delete = new DeleteController;






# =*|*=[ DELETE DATA ]=*|*=
/**
 * Read The Deleted Data Details (to also delete previous stored image)
 * Query To Delete Data
 * Delete Image File
 * Confirmation Notification and Refresh Page After 3 Second
 */
if (isset($_REQUEST['did'])) {
   $getDeleteData = $read->findOn('admins', 'id', $_REQUEST['did']);
   $deleteAdmin = $delete->deleteAll('admins', $_REQUEST['did']);

   if ($deleteAdmin > 0) {
      unlink($GLOBALS['ADMINS_DIR'] . $getDeleteData[0]['admin_avatar']);
      echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('admin-list') . "'>";
      echo $misc->alertNotification('success', 'top', 13, 'admin data is deleted successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 13, 'something went wrong');
   }
}


# =*|*=[ CHANGE or UPDATE CURRENT STATUS ]=*|*=
/**
 * Status Changed Query Execution
 * Confirmation Notification
 */
if (isset($_POST['change_status'])) {
   //
   $changeCurrentStatus = $update->changeStatus(
      'admins',
      'admin_status',
      $_POST['current_status'],
      $_POST['change_id']
   );

   if ($changeCurrentStatus > 0) {
      echo $misc->alertNotification('success', 'top', 13, 'status is changed successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 13, 'something went wrong');
   }
}


# =*|*=[ READ DATA ]=*|*=
$adminList = $read->all('admins');

?>

<!-- =+|+= ADMIN LIST PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive pt-4">
                  <table class="table table-hover mb-0 table-sm">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Name</th>
                           <th scope="col">Email</th>
                           <th scope="col">Mobile</th>
                           <th scope="col">Admin Type</th>
                           <th scope="col">Image</th>
                           <th scope="col">Status</th>
                           <th scope="col">Created Date</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        if (!empty($adminList) && is_array($adminList)) {
                           foreach ($adminList as $each) {
                              $avatar = $GLOBALS['ADMINS_DIR'] . $each['admin_avatar'];
                        ?>
                              <tr>
                                 <th scope="row">
                                    <button type="button" class="btn btn-light btn-sm font-weight-bold waves-effect waves-light">
                                       <i class="ti-user"></i>
                                    </button>
                                 </th>
                                 <td>
                                    <?php echo $each['admin_name']; ?>
                                 </td>
                                 <td>
                                    <?php echo $each['admin_email']; ?>
                                 </td>
                                 <td>
                                    <?php echo $each['admin_mobile']; ?>
                                 </td>
                                 <td>
                                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light mw-98">
                                       <?php echo $each['admin_role_type']; ?>
                                    </button>
                                 </td>
                                 <td>
                                    <img src="<?php echo $avatar; ?>" alt="" class="thumb-sm rounded-circle mr-2">
                                 </td>
                                 <td>
                                    <?php echo $comp->changeStatus($each['id'], $each['admin_status']); ?>
                                 </td>
                                 <td>
                                    <?php echo $date->dateFull($each['created_at']); ?>
                                 </td>
                                 <td>
                                    <div class="d-inline">
                                       <button type="button" class="btn btn-light btn-sm waves-effect waves-light profile" data-toggle="modal" data-target="#adminProfile" data-id="<?php echo $each['id']; ?>">
                                          <i class="ti-eye"></i>
                                       </button>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deleteAdmin" data-did="<?php echo $each['id']; ?>">
                                       <i class="ti-trash"></i>
                                    </button>
                                 </td>
                              </tr>

                        <?php
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
<!-- =+|+= ADMIN LIST PAGE CONTENT [END] =+|+= -->


<!-- =+|+= ADMIN PROFILE MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="adminProfile" aria-labelledby="adminProfileModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="card mb-0" id="adminProfileDetails">
               <!-- Admin Profile Details -->
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= ADMIN PROFILE MODAL CONTENT [END] =+|+= -->


<!-- =+|+= DELETE ADMIN MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteAdmin" aria-labelledby="deleteAdminModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="card-body pb-1">
               <h4 class="card-title font-16 mt-0 font-weight-normal">
                  Do your really want to delete this <span id="getName"></span>'s data?
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
<!-- =+|+= DELETE ADMIN MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {

      //Admin Profile Details
      $(document).on("click", ".profile", function() {
         let id = $(this).data("id");

         if (id !== '') {
            $.ajax({
               url: 'sync.php',
               type: 'POST',
               data: {
                  action: "ADMIN_PROFILE",
                  id: id
               },
               success: function(data) {
                  $("#adminProfileDetails").html(data);
               }
            });
         }
      });



      //Delete Modal and Get Delete Name
      $(document).on("click", ".deleteData", function() {
         let id = $(this).data("did");

         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "DELETE_DATA",
               deleteFrom: "admins",
               deleteName: "admin_name",
               did: id
            },
            success: function(data) {
               $("#getName").html(data);
            }
         });

         $("#deleteData").attr("href", "admin-list.php?did=" + id);
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->