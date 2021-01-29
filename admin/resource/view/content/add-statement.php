<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] CreateController
 * [3] ReadController
 */
$misc = new MiscellaneousController;
$create = new CreateController;
$read = new ReadController;



/**
 * [Create Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Existing Conditional Query Execute to Prevent Duplicate Post on Same Date and Category
 * If Data is Not Exist, then Execute Create Query and Flash Confirmation Notification
 */

if (isset($_POST['createStatement'])) {
   if (strlen($_POST['_token']) === 32) {

      if(!empty($_POST['isAppointment'])) {
         $isAppointment = $_POST['isAppointment'];
      } else {
         $isAppointment = "No";
      }

      $checkExistingData = $read->isExistOnCondition('statement', 'date', $misc->sqlDate($_POST['preparedOn']), 'type', $_POST['type'], 'account_id', $_POST['category']);
      if ($checkExistingData === 1) {
         echo $misc->alertNotification('primary', 'top', 14, 'might be some data is already exist');
      } else {
         $creataStatement = $create->createStatement($misc->sqlDate($_POST['preparedOn']), $_POST['type'], $_POST['category'], $misc->sqlDateTime($_POST['preparedOn']), $_POST['issued'], $_POST['approved'], $_POST['description'], $_POST['grandTotal'], $isAppointment);
         if (!empty($creataStatement)) {
            for ($i = 0; $i < count($_POST['purpose']); $i++) {
               $createStatementDetails = $create->createStatementDetails($_POST['type'], $creataStatement, $_POST['purpose'][$i], $_POST['net'][$i], $_POST['vat'][$i], $_POST['total'][$i]);
            }

            if (!empty($createStatementDetails)) {
               echo $misc->alertNotification('success', 'top', 14, 'expense data is addedd successfully');
            } else {
               echo $misc->alertNotification('primary', 'top', 14, 'something went wrong..');
            }
         }
      }
   }
}



/**
 * [Read Data]
 * 
 * Read All The Required Table Data Such as:
 * [1] Admins
 * [2] Accounts
 */
$fetchAdmins = $read->all('admins');
$accountType = $read->uniqueOn('accounts', 'type');

?>

<!-- =+|+= ADD ACCOUNTS STATEMENT PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-10 offset-md-1 pt-4">
                     <form action="" method="POST" class="customFormInput">
                        <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Account On</strong></label>
                           <div class="col-md-6">
                              <select class="custom-select" name="type" id="type">
                                 <option selected>Please Select..</option>

                                 <?php
                                 if (!empty($accountType) && is_array($accountType)) {
                                    foreach ($accountType as $each) {
                                       echo '<option value="' . $each['type'] . '">' . $each['type'] . '</option>';
                                    }
                                 }
                                 ?>

                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-md-2 col-form-label"><strong>Category</strong></label>
                           <div class="col-md-6">
                              <select class="custom-select" name="category" id="category">
                                 <option selected>Please Select..</option>
                                 <!-- All The Category Data Appeared Based On Account Type -->
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Billing Date</strong></label>
                           <div class="col-md-6">
                              <input class="form-control datepicker-here" type="text" name="preparedOn" placeholder="<?php echo date('m/d/Y h:i a'); ?>" data-language='en' data-timepicker="true" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Issued By</strong></label>
                           <div class="col-md-6">
                              <input class="form-control" type="text" name="issued" placeholder="Jhon Doe" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Approved By</strong></label>
                           <div class="col-md-6">
                              <select class="custom-select" name="approved">
                                 <option selected>Please Select..</option>

                                 <?php
                                 if (!empty($fetchAdmins) && is_array($fetchAdmins)) {
                                    foreach ($fetchAdmins as $each) {
                                       echo '<option value="' . $each['id'] . '">' . $each['admin_role_type'] . '</option>';
                                    }
                                 }
                                 ?>

                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label"><strong>Description</strong></label>
                           <div class="col-md-6">
                              <input class="form-control" type="text" name="description" placeholder="Type Something (optional)" />
                           </div>
                        </div>
                        <div id="isAppointment" style="display: none;">
                           <div class="form-group row">
                              <label for="" class="col-md-2 col-form-label"></label>
                              <div class="col-md-6">
                                 <div class="custom-control custom-checkbox" style="margin-top: 6px;">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="isAppointment" value="Yes">
                                    <label class="custom-control-label" for="customCheck1">Check this Statement as Appointment Purpose</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label">
                              <strong>Add Statement</strong>
                           </label>
                           <div class="col-md-10">
                              <table class="table table-sm">
                                 <thead>
                                    <tr>
                                       <th scope="col" style="width: 3%;">Sl.</th>
                                       <th scope="col" style="width: 40%;">Purpose</th>
                                       <th scope="col" style="width: 17%;">Net Amount</th>
                                       <th scope="col" style="width: 17%;">Vat Amount</th>
                                       <th scope="col" style="width: 18%;">Total Amount</th>
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
                                          <input type="text" name="purpose[]" placeholder="Purpose here.." class="form-control" />
                                       </td>
                                       <td>
                                          <input type="number" value="" name="net[]" min="1" class="form-control" id="netAmount1" />
                                       </td>
                                       <td>
                                          <input type="number" value="" name="vat[]" min="0" step="any" class="form-control" id="vatAmount1" />
                                       </td>
                                       <td>
                                          <input type="text" readonly value="" name="total[]" class="form-control bg-white font-weight-bold" id="total1" />
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
                        <div class="form-group row">
                           <label for="" class="col-md-2 col-form-label">
                              <strong>Total Amount</strong>
                           </label>
                           <div class="col-md-6">
                              <input class="form-control bg-white font-weight-bold" type="text" name="grandTotal" id="grandTotal" readonly value="" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-6 offset-md-2 pt-4">
                              <button type="submit" name="createStatement" class="btn btn-primary btn-block waves-effect waves-light">
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
<!-- =+|+= ADD ACCOUNTS STATEMENT PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {

      /**
       * Get Statement Type Based Category Options
       * Condition to Send AJAX Request to Get Categories
       * Pass All The Values Into The Specific ID
       */
      $(document).on('change', '#type', function(e) {
         let statementType = $(this).val();
         if (statementType !== null) {
            $.ajax({
               url: 'sync.php',
               type: 'POST',
               data: {
                  action: "GET_CATEGORY_ON_TYPE",
                  name: statementType
               },
               success: function(data) {
                  $('#category').html(data);
               }
            });
         }

         if(statementType !== null && statementType === "Income") {
            $('#isAppointment').show();
         } else {
            $('#isAppointment').hide();
         }
      });


      /**
       * [Each Rows Total Value Calculation]
       *
       * Assign Variable with Zero Values to Get All Total Value as Grand Total
       * Create Loop for Each Appending Rows and Assign Variable with Zero Values to Get Each Total Value
       * Condition to Parse Each Rows Net and Vat Values and Pass it Into the Specific ID's
       */
      function getEachTotal(n) {
         let grandTotal = 0;

         for (i = 1; i <= n; i++) {
            let net = 0;
            let vat = 0;
            let total = 0;

            net = $('#netAmount' + i).val();
            if (net > 0) {
               vat = $('#vatAmount' + i).val();
               if (vat > 0) {
                  total = parseFloat(net) + (parseFloat(net) * parseFloat(vat) / 100);
                  grandTotal = parseFloat(grandTotal) + parseFloat(total);
               } else {
                  total = parseFloat(net);
                  grandTotal = parseFloat(grandTotal) + parseFloat(total);
               }
            }
            $('#total' + i).val(total.toFixed(2));
         }
         $('#grandTotal').val(grandTotal.toFixed(2));
      }


      //On Keyup Get Calculation Value
      $(document).on('keyup change click', function() {
         getEachTotal(n);
      });


      /**
       * On Click Append a New Row
       * Assign Variable to Increment Based on Row
       * Condition to Reader Rows
       */
      let n = 1;

      $(document).on('click', '#addNewRow', function() {
         let isValueExist = $('#total1').val();
         if (isValueExist !== '' && isValueExist > 0) {
            $('#appendRows').append(addNewRows());
            n++;
         } else {
            return false;
         }
      });


      /** 
       * On Click Remove a Row
       * Get All the Required Data Such as
       * [1] Requested ID to Delete
       * [2] Total Value of the ID Which will be Deleted
       * [3] Grand Total Value as well
       * Substract Grand Total Value Form The Deleted Rows Value
       * Remove A Table Row With Fade Effects After 300 Seconds
       */
      $(document).on('click', '.removeRow', function() {
         let deleteId = $(this).attr('did');
         let deleteValue = $('#total' + deleteId).val();
         let totalValue = $('#grandTotal').val();
         let totalRevisedAmount = parseFloat(totalValue) - parseFloat(deleteValue);

         $('#grandTotal').val(totalRevisedAmount.toFixed(2));
         $('#contentRow' + deleteId).fadeOut(300, function() {
            $(this).remove();
         });
      });


      //Template Literature for Appending Rows
      function addNewRows() {
         let addNewRows = `
            <tr id="contentRow${1+n}">
               <td>
                  <button class="btn btn-light text-dark waves-effects waves-light" type="button">
                     <i class="ion-edit"></i>
                  </button>
               </td>
               <td>
                  <input type="text" name="purpose[]" placeholder="Purpose here.." class="form-control" />
               </td>
               <td>
                  <input type="number" value="" min="1" name="net[]" class="form-control" id="netAmount${1+n}" />
               </td>
               <td>
                  <input type="number" value="" min="0" step="any" name="vat[]" class="form-control" id="vatAmount${1+n}" />
               </td>
               <td>
                  <input class="form-control bg-white font-weight-bold" type="text" readonly value="" name="total[]" id="total${1+n}" />
               </td>
               <td>
                  <button class="btn btn-primary waves-effect waves-light removeRow" type="button" did="${1+n}">
                     <i class="ion-close-round"></i>
                  </button>
               </td>
            </tr>
         `;

         return addNewRows;
      }
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->