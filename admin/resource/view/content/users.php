<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ComponentController
 * [3] ReadController
 * [4] UpdateController
 */
$misc = new MiscellaneousController;
$comp = new ComponentController;
$read = new ReadController;
$update = new UpdateController;



/**
 * [Update Data]
 * 
 * On Submit Execute Change Query and 
 * On Condition Flash Confirmation Notification
 */
if (isset($_POST['change_status'])) {
   $changeCurrentStatus = $update->changeStatus('users', 'status', $_POST['current_status'], $_POST['change_id']);
   if ($changeCurrentStatus > 0) {
      echo $misc->alertNotification('success', 'top', 16, 'status is changed successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
   }
}



/**
 * [Read Data]
 */
$fetchUsersData = $read->all('users', true);

?>

<!-- =+|+= USER LIST PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="pt-3">
                  <table class="table dt-responsive nowrap datatable table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th scope="col" style="width: 5%;">#</th>
                           <th scope="col" style="width: 18%;">Name</th>
                           <th scope="col" style="width: 15%;">Mobile</th>
                           <th scope="col" style="width: 15%;">Email</th>
                           <th scope="col" style="width: 10%;">Avatar</th>
                           <th scope="col" style="width: 12%;">Status</th>
                           <th scope="col" style="width: 15%;">Created Date</th>
                           <th scope="col" style="width: 10%;">Action</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        /**
                         * Assign a Variable for Auto Increment
                         * Assign Variable On Condition Image Files Exist or Not
                         */
                        if (!empty($fetchUsersData)) {
                           $n = 1;
                           if (is_array($fetchUsersData)) {
                              foreach ($fetchUsersData as $eachUser) {

                                 if (!empty($eachUser['avatar'])) {
                                    $avatar = $GLOBALS['USERS_DIR'] . $eachUser['avatar'];
                                 } else {
                                    $avatar = 'public/assets/images/img-1.jpg';
                                 }
                        ?>

                                 <tr>
                                    <td class="font-weight-bold">
                                       <?php echo $n; ?>
                                    </td>
                                    <td>
                                       <?php echo $eachUser['full_name']; ?>
                                    </td>
                                    <td>
                                       <?php echo $eachUser['mobile']; ?>
                                    </td>
                                    <td>
                                       <?php echo $eachUser['email']; ?>
                                    </td>
                                    <td class="text-center">
                                       <img src="<?php echo $avatar; ?>" alt="" class="thumb-sm rounded-circle mr-2">
                                    </td>
                                    <td>
                                       <?php echo $comp->changeStatus($eachUser['id'], $eachUser['status']); ?>
                                    </td>
                                    <td>
                                       <?php echo $misc->dateTime($eachUser['created_at']); ?>
                                    </td>
                                    <td>
                                       <div class="d-flex">
                                          <form action="user-profile" method="POST">
                                             <input type="hidden" name="id" value="<?php echo $eachUser['id']; ?>">
                                             <button type="submit" class="btn btn-light btn-sm waves-effect waves-light mr-1" name="userProfile">
                                                <i class="ti-eye"></i>
                                             </button>
                                          </form>
                                          <button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deleteUser" data-did="<?php echo $eachUser['id']; ?>">
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
<!-- =+|+= USER LIST PAGE CONTENT [END] =+|+= -->


<!-- =+|+= DELETE USER MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteUser" aria-labelledby="deleteUserModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="card-body pb-1">
               <h4 class="card-title font-16 mt-0 font-weight-normal">
                  Do your really want to delete this <span id="getName"></span>'s info?
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
<!-- =+|+= DELETE USER MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {
      // Request to Delete Based on ID
      // Get Deleted Name
      $(document).on("click", ".deleteData", function() {
         let id = $(this).data("did");
         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "DELETE_DATA",
               deleteFrom: "users",
               deleteName: "full_name",
               did: id
            },
            success: function(data) {
               $("#getName").html(data);
            }
         });
         $("#deleteData").attr("href", "users.php?did=" + id);
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->