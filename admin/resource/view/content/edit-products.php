<?php

/**
 * [ Object Defined ]
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
 * [3] CreateController
 * [4] ReadController
 * [5] DeleteController
 * [6] UpdateController
 */
$misc = new MiscellaneousController;
$create = new CreateController;
$read = new ReadController;
$delete = new DeleteController;
$update = new UpdateController;



/**
 * [Delete Data]
 * 
 * Execute Delete Query and Flash Confirmation Notifiction Based on Action
 */
if (isset($_REQUEST['did'])) {
   $deletProduct = $delete->deleteAll('products', $_REQUEST['did']);
   if ($deletProduct > 0) {
      echo "<meta http-equiv='refresh' content='3;url=" . $misc->getPath('edit-products') . "'>";
      echo $misc->alertNotification('success', 'top', 16, 'product data is deleted successfully');
   } else {
      echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
   }
}



/**
 * [ Update Data ]
 * 
 * Update Form Submission Validation by "TOKEN"
 * Execute Update Query Based on File Condition
 * Flash Confirmation Notification and Upload a New Files & Remove Previous Files (if required)
 */

if (isset($_POST['updateProduct'])) {
   if (strlen($_POST['_token']) === 32) {
      $updateProduct = $update->updateProduct($_POST['service'], $_POST['product'], $_POST['details'], $_POST['price'], $_POST['status'], $_POST['id']);
      if ($updateProduct > 0) {
         echo $misc->alertNotification('success', 'top', 16, 'product data is updated successfully');
      } else {
         echo $misc->alertNotification('primary', 'top', 16, 'something went wrong');
      }
   }
}



/**
 * [ Read Data ]
 * 
 * When Set a POST Method is Done then Assign a Session Based on ID
 * Fetch Required Data Array Such as:
 * [1] Services
 * [2] Products
 */
if (isset($_POST['editProduct'])) {
   $_SESSION['get_product_list'] = $_POST['id'];
}

$fetchServices = $read->findOn('services', 'status', '"Active"');
$fetchProducts = $read->findOn('products', 'service_id', $_SESSION['get_product_list']);

?>

<style>
   /* Define Required Styles (for this page only) */
   .custom-select-sm {
      padding-top: 5px;
   }
</style>

<!-- =+|+= EDIT PRODUCTS PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 pt-4">
                     <div class="table-responsive">
                        <table class="table dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                           <thead>
                              <tr>
                                 <th scope="col" style="width: 3%;">#</th>
                                 <th scope="col" style="width: 18%;">Service Type</th>
                                 <th scope="col" style="width: 25%;">Product Name</th>
                                 <th scope="col" style="width: 24%;">Product Details (Optional)</th>
                                 <th scope="col" style="width: 10%;">Price</th>
                                 <th scope="col" style="width: 10%;">Status</th>
                                 <th scope="col" style="width: 10%;">Action</th>
                              </tr>
                           </thead>
                           <tbody>

                              <?php
                              if (!empty($fetchProducts) && is_array($fetchProducts)) {
                                 $n = 1;
                                 foreach ($fetchProducts as $eachProduct) {
                                    $getServiceData = $read->findOn('services', 'id', $eachProduct['service_id']);
                              ?>

                                    <tr>
                                       <form action="" method="POST">
                                          <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>">
                                          <input type="hidden" name="id" value="<?php echo $eachProduct['id']; ?>">
                                          <td class="font-weight-bold">
                                             <?php echo $n; ?>
                                          </td>
                                          <td>
                                             <select class="custom-select custom-select-sm" name="service">
                                                <option value="<?php echo $getServiceData[0]['id']; ?>"><?php echo $getServiceData[0]['title']; ?></option>

                                                <?php
                                                if (!empty($fetchServices) && is_array($fetchServices)) {
                                                   foreach ($fetchServices as $eachService) {
                                                      if ($eachService['title'] !== $getServiceData[0]['title']) {
                                                         echo '<option value="' . $eachService['id'] . '">' . $eachService['title'] . '</option>';
                                                         continue;
                                                      }
                                                   }
                                                }
                                                ?>

                                             </select>
                                          </td>
                                          <td>
                                             <input type="text" name="product" class="form-control form-control-sm" value="<?php echo $eachProduct['title']; ?>" />
                                          </td>
                                          <td>
                                             <input type="text" name="details" class="form-control form-control-sm" value="<?php echo $eachProduct['details']; ?>" />
                                          </td>
                                          <td>
                                             <input type="text" name="price" class="form-control form-control-sm" value="<?php echo $eachProduct['price']; ?>" />
                                          </td>
                                          <td>
                                             <select class="custom-select custom-select-sm" name="status">
                                                <option <?php if ($eachProduct['status'] === "Active") echo "selected"; ?>>Active</option>
                                                <option <?php if ($eachProduct['status'] === "Inactive") echo "selected"; ?>>Inactive</option>
                                             </select>
                                          </td>
                                          <td>
                                             <div class="d-inline">
                                                <button class="btn btn-light btn-sm waves-effect waves-light" type="submit" name="updateProduct">
                                                   <i class="ti-pencil-alt"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light deleteData" data-toggle="modal" data-target="#deletePricing" data-did="<?php echo $eachProduct['id']; ?>">
                                                   <i class="ti-trash"></i>
                                                </button>
                                             </div>
                                          </td>
                                       </form>
                                    </tr>

                              <?php
                                    $n++;
                                 }
                              } else {
                                 echo '<td colspan="7">
                                          <h4 class="text-muted text-center">No matching records found...</h4>
                                       </td>';
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
<!-- =+|+= EDIT PRODUCTS PAGE CONTENT [END] =+|+= -->


<!-- =+|+= DELETE PRODUCT MODAL CONTENT [START] =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deletePricing" aria-labelledby="deletePricingModal" aria-hidden="true">
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
<!-- =+|+= DELETE PRODUCT MODAL CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {
      //Delete Modal and Get Delete Name
      $(document).on("click", ".deleteData", function(e) {
         let id = $(this).data("did");

         $.ajax({
            url: "sync.php",
            type: "POST",
            data: {
               action: "DELETE_DATA",
               deleteFrom: "products",
               deleteName: "title",
               did: id
            },
            success: function(data) {
               console.log(data);
               $("#getName").html(data);
            }
         });

         $("#deleteData").attr("href", "edit-products.php?did=" + id);
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->