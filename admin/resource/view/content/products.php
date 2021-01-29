<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
 * [3] CreateController
 * [4] ReadController
 */
$misc = new MiscellaneousController;
$create = new CreateController;
$read = new ReadController;



/**
 * [Create Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Execute Create Query Based on Condition and Flash Confirmation Notification
 * 
 * Note: Due to Array The Query Will Be Execute Through Loop
 */
if (isset($_POST['createProduct'])) {
   if (strlen($_POST['_token']) === 32) {
      if (is_array($_POST)) {
         for ($i = 0; $i < count($_POST['services']); $i++) {
            $createProducts = $create->createProduct($_POST['services'][$i], $misc->productID(), $_POST['product'][$i], $_POST['details'][$i], $_POST['price'][$i], $_POST['status'][$i]);
         }
         if (!empty($createProducts)) {
            echo $misc->alertNotification('success', 'top', 14, 'products data is added successfully');
         } else {
            echo $misc->alertNotification('primary', 'top', 14, 'something went wrong..');
         }
      }
   }
}



/**
 * [Read Data]
 */
$fetchServices = $read->findOn('services', 'status', '"Active"');

?>

<!-- =+|+= ADD PRODUCT PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-12 px-4 pt-4">
                     <form action="" method="POST" class="customFormInput" id="addProductForm">
                        <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                        <div class="form-group">
                           <label for=""><strong>Service Pricing</strong></label>
                           <div class="table-responsive">
                              <table class="table table-sm">
                                 <thead>
                                    <tr>
                                       <th scope="col" style="width: 3%;">Sl.</th>
                                       <th scope="col" style="width: 18%;">Service Type</th>
                                       <th scope="col" style="width: 28%;">Product Name</th>
                                       <th scope="col" style="width: 24%;">Product Details (Optional)</th>
                                       <th scope="col" style="width: 11%;">Price</th>
                                       <th scope="col" style="width: 11%;">Status</th>
                                       <th scope="col" style="width: 5%;">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody id="appendRows">
                                    <tr id="contentRow">
                                       <td>
                                          <button class="btn btn-light text-dark waves-effects waves-light" type="button">
                                             <i class="ion-edit"></i>
                                          </button>
                                       </td>
                                       <td>
                                          <select class="custom-select" name="services[]">
                                             <option selected disabled>Please Select..</option>
                                             <?php
                                             if (!empty($fetchServices) && is_array($fetchServices)) {
                                                foreach ($fetchServices as $eachService) {
                                                   echo '<option value="' . $eachService['id'] . '">' . $eachService['title'] . '</option>';
                                                }
                                             }
                                             ?>
                                          </select>
                                       </td>
                                       <td>
                                          <input type="text" name="product[]" class="form-control" placeholder="Product Name" />
                                       </td>
                                       <td>
                                          <input type="text" name="details[]" class="form-control" placeholder="Product Details" />
                                       </td>
                                       <td>
                                          <input type="text" name="price[]" class="form-control" />
                                       </td>
                                       <td>
                                          <select class="custom-select" name="status[]">
                                             <option selected disabled>Choose</option>
                                             <option value="Active">Active</option>
                                             <option value="Inactive">Inactive</option>
                                          </select>
                                       </td>
                                       <td>
                                          <button class="btn btn-success waves-effect waves-light" type="button" id="addNewRow">
                                             <i class="ion-plus-round"></i>
                                          </button>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="pt-3">
                              <button type="submit" name="createProduct" class="btn btn-primary btn-block waves-effect waves-light">
                                 Confirm &amp; Save
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= ADD PRODUCT PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {
      let n = 1;

      //Empty Form Submission Prevention
      $(document).on('submit', '#addProductForm', function(e) {
         let service = $('[name="services[]"]').val();
         let product = $('[name="product[]"]').val();
         let price = $('[name="price[]"]').val();
         let status = $('[name="status[]"]').val();

         if (service !== null && product !== '' && price !== '' && status !== null) {
            return true;
         } else {
            e.preventDefault();
            confirm('Please make sure that all fields are not empty');
            return false;
         }
      });


      //Add A New Rows
      $(document).on('click', '#addNewRow', function() {
         $('#appendRows').append(rowTemplate());
         n++;
      });


      //Remove A Rows
      $(document).on('click', '.removeRow', function() {
         let deleteId = $(this).attr('did');
         $('#contentRow' + deleteId).fadeOut(300, function() {
            $(this).remove();
         });
      });


      //Template Literature
      function rowTemplate() {
         let rowTemplate = `
            <tr id="contentRow${n}">
               <td>
                  <button class="btn btn-light text-dark waves-effects waves-light"
                     type="button">
                     <i class="ion-edit"></i>
                  </button>
               </td>
               <td>
                  <select class="custom-select" name="services[]">
                     <option selected>Please Select..</option>
                     <?php
                     if (!empty($fetchServices) && is_array($fetchServices)) {
                        foreach ($fetchServices as $eachService) {
                           echo '<option value="' . $eachService['id'] . '">' . $eachService['title'] . '</option>';
                        }
                     }
                     ?>
                  </select>
               </td>
               <td>
                  <input type="text" name="product[]" class="form-control"
                     placeholder="Product Name" />
               </td>
               <td>
                  <input type="text" name="details[]" class="form-control"
                     placeholder="Product Details (Optional)" />
               </td>
               <td>
                  <input type="text" name="price[]" class="form-control" />
               </td>
               <td>
                  <select class="custom-select" name="status[]">
                     <option selected disabled>Choose</option>
                     <option value="Active">Active</option>
                     <option value="Inactive">Inactive</option>
                  </select>
               </td>
               <td>
                  <button class="btn btn-primary waves-effect waves-light removeRow" type="button" did="${n}">
                     <i class="ion-close-round"></i>
                  </button>
               </td>
            </tr>
         `;

         return rowTemplate;
      }
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->