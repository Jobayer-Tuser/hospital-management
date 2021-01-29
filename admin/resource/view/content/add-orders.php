<?php

/**
 * [Object Defined]
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] CreateController
 * [3] ReadController
 */
$misc = new MiscellaneousController;
$comp = new ComponentController;
$create = new CreateController;
$read = new ReadController;
$update = new UpdateController;
$delete = new DeleteController;


/**
 * [Create and/or Delete Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Read Previous Data Based On Conditions
 * Assign Empty Arrays and Get All The Required Data Through Loop
 * Execute Create and Delete Query Based on Condition 
 * Flash All Kind Of Confirmation Notification Based on Query Execution
 */
if (isset($_POST['confirmOrder'])) {
   if (strlen($_POST['_token']) === 32) {
      if ($_POST['status'] === "Confirmed") {
         $getShopCartData = $read->findOn('shopcarts', 'id', $_POST['cart_id']);
         $getUserDetails = $read->findOn('users', 'id', $getShopCartData[0]['user_id']);
         $getOrderItems = $read->findOn('order_items', 'shopcart_id', $getShopCartData[0]['id']);
         $orderItemsID = [];
         $getServiceTitle = [];
         $getProductTitle = [];
         $getProductPrice = [];

         if (!empty($getOrderItems) && is_array($getOrderItems)) {
            foreach ($getOrderItems as $each) {
               array_push($orderItemsID, $each['id']);
               $getServices = $read->findOn('services', 'id', $each['service_title']);
               $getProducts = $read->findOn('products', 'id', $each['product_id']);

               if (!empty($getServices) && !empty($getProducts)) {
                  foreach ($getServices as $eachService) {
                     array_push($getServiceTitle, $eachService['title']);
                  }
                  foreach ($getProducts as $eachProduct) {
                     array_push($getProductTitle, $eachProduct['title']);
                     array_push($getProductPrice, $eachProduct['price']);
                  }
               }
            }
         }

         if (!empty($getProductPrice) && is_array($getProductPrice)) {
            for ($i = 0; $i < count($getProductPrice); $i++) {
               $createInventory = $create->addInventory(
                  $getShopCartData[0]['date'],
                  $getUserDetails[0]['user_id'],
                  $getUserDetails[0]['full_name'],
                  $getUserDetails[0]['email'],
                  $getUserDetails[0]['mobile'],
                  $getServiceTitle[$i],
                  $getProductTitle[$i],
                  $getProductPrice[$i],
               );
               if (!empty($createInventory)) {
                  if(!empty($orderItemsID) && is_array($orderItemsID)) {
                     for ($i = 0; $i < count($orderItemsID); $i++) {
                        $deleteOrderItems = $delete->deleteAll('order_items', $orderItemsID[$i]);
                     }
                     if (!empty($deleteOrderItems)) {
                        $deleteCartData = $delete->deleteAll('shopcarts', $_POST['cart_id']);
                        if (!empty($deleteCartData)) {
                           echo $misc->alertNotification('success', 'top', 14, 'inventory is added successfully');
                        } else {
                           echo $misc->alertNotification('primary', 'top', 14, 'something went wrong');
                        }
                     }
                  }
               }
            }
         }
      } else {
         echo $misc->alertNotification('primary', 'top', 14, 'make sure cart status is confirmed..');
      }
   }
}


/**
 * [Create and/or Update Data]
 * 
 * Create Form Submission Validation by "TOKEN"
 * Read Previous Data to Prevent Duplicate Based on the Same User and Date
 * Condition Differs to "Add Cart" Data Such as either Create or Update
 * 
 * If Previous Records Not Found:
 * [1] ShopCart Create Query will be Execute and Assign a Session
 * [2] Multiple Product Create Query will be Execute through for-loop
 * 
 * Else Previous Records Found:
 * [1] ShopCart Update Query will be Execute
 * [2] Multiple Product Create Query will be Execute through for-loop
 * 
 * Flash All Kind Of Confirmation Notification Based on Query Execution
 */
if (isset($_POST['createOrders'])) {
   if (strlen($_POST['_token']) === 32) {
      $checkPreviousData = $read->isExistOnCondition('shopcarts', 'date', $misc->sqlDate($_POST['orderDate']), 'user_id', $_POST['user']);
      if ($checkPreviousData === 0) {
         $addToCart = $create->addToCart($misc->sqlDate($_POST['orderDate']), $_POST['user'], array_sum($_POST['price']));
         $_SESSION['last_insert_id'] = $addToCart;
         if (!empty($addToCart)) {
            if (is_array($_POST['service'])) {
               for ($i = 0; $i < count($_POST['service']); $i++) {
                  $addOrderItems = $create->addOrderItems($_SESSION['last_insert_id'], $_POST['service'][$i], $_POST['product'][$i], $_POST['price'][$i]);
               }
               if (!empty($addOrderItems)) {
                  echo $misc->alertNotification('success', 'top', 14, 'shop cart data is successfully done');
               } else {
                  echo $misc->alertNotification('primary', 'top', 14, 'something went wrong');
               }
            }
         }
      } else {
         $getStoredRecord = $read->findOn('shopcarts', 'user_id', $_POST['user'], 'date', '"' . $misc->sqlDate($_POST['orderDate']) . '"');
         $updatePrice = array_sum($_POST['price']) + $getStoredRecord[0]['price_total'];
         $updateAddToCart = $update->updateCart($updatePrice, $getStoredRecord[0]['id'], $misc->sqlDate($_POST['orderDate']));
         if (!empty($updateAddToCart)) {
            if (is_array($_POST['service'])) {
               for ($i = 0; $i < count($_POST['service']); $i++) {
                  $updateOrderItems = $create->addOrderItems($getStoredRecord[0]['id'], $_POST['service'][$i], $_POST['product'][$i], $_POST['price'][$i]);
               }
               if (!empty($updateOrderItems)) {
                  echo $misc->alertNotification('success', 'top', 14, 'shop cart data is successfully done');
               } else {
                  echo $misc->alertNotification('primary', 'top', 14, 'something went wrong');
               }
            }
         }
      }
   }
}


/**
 * [Read Data]
 * 
 * Fetch All The Required Table Data Such as:
 * [1] Users
 * [2] Services
 * [3] ShopCarts
 */
$fetchUsers = $read->findOn('users', 'status', '"Active"');
$fetchServices = $read->findOn('services', 'status', '"Active"');
$fetchOrders = $read->all('shopcarts', true);

?>

<!-- =+|+= Add New Order Page Content -Start- =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body pb-0">
               <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active show" data-toggle="tab" href="#newOrder" role="tab" aria-selected="true">
                        <i class="ion-android-sort"></i> Manage New Order List
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#addOrder" role="tab" aria-selected="true">
                        <i class="ion-android-add"></i> Create A New Order
                     </a>
                  </li>
               </ul>
               <div class="tab-content">

                  <!-- manage new order list tab -->
                  <div class="tab-pane p-3 mb-1 active show" id="newOrder" role="tabpanel">
                     <div class="">
                        <table class="table dt-responsive nowrap datatable"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">User Name</th>
                                 <th scope="col">User Email</th>
                                 <th scope="col">User Mobile</th>
                                 <th scope="col">Price Total</th>
                                 <th scope="col">Order Date</th>
                                 <th scope="col">Status</th>
                                 <th scope="col">Details</th>
                                 <th scope="col">Action</th>
                              </tr>
                           </thead>
                           <tbody>

                              <?php
                              /**
                               * Conditional Check and Assign a Variable for Increment
                               * Read All The Required Table Such As:
                               * [1] Users
                               * 
                               * Note: Each Row Will Be Perform as a Form
                               */
                              if (!empty($fetchOrders) && is_array($fetchOrders)) {
                                 $n = 1;
                                 foreach ($fetchOrders as $eachOrder) {
                                    $userData = $read->findOn('users', 'id', $eachOrder['user_id']);
                              ?>

                                    <tr>
                                       <form action="" method="POST">
                                          <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>">
                                          <input type="hidden" name="cart_id" value="<?php echo $eachOrder['id']; ?>">
                                          <td class="font-weight-bold"><?php echo $n; ?></td>
                                          <td><?php echo $userData[0]['full_name']; ?></td>
                                          <td><?php echo $userData[0]['email']; ?></td>
                                          <td>+88 <?php echo $userData[0]['mobile']; ?></td>
                                          <td><?php echo $eachOrder['price_total']; ?></td>
                                          <td><?php echo $misc->dateOnly($eachOrder['date']); ?></td>
                                          <td>
                                             <div>
                                                <select class="custom-select custom-select-sm" name="status"
                                                   style="padding-top:4px;" data-uid="<?php echo $eachOrder['id']; ?>">
                                                   <option
                                                      <?php if ($eachOrder['status'] == "Pending") echo 'selected'; ?>>Pending
                                                   </option>
                                                   <option
                                                      <?php if ($eachOrder['status'] == "Confirmed") echo 'selected'; ?>>Confirmed
                                                   </option>
                                                </select>
                                             </div>
                                          </td>
                                          <td>
                                             <button type="button"
                                                class="btn btn-light btn-sm waves-effect waves-light viewItems"
                                                data-toggle="modal" data-target="#cartItemDetails"
                                                data-vid="<?php echo $eachOrder['id']; ?>">
                                                <i class="ti-eye"></i> Details
                                             </button>
                                          </td>
                                          <td>
                                             <div class="d-inline-block">
                                                <button type="submit"
                                                   class="btn btn-success btn-sm waves-effect waves-light"
                                                   name="confirmOrder">
                                                   <i class="ti-plus"></i>
                                                </button>
                                                <button type="button"
                                                   class="btn btn-danger btn-sm waves-effect waves-light deleteData"
                                                   data-toggle="modal" data-target="#deleteCartData"
                                                   data-did="<?php echo $eachOrder['id']; ?>">
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
                  <!-- manage new order list tab -->

                  <!-- create a new order list tab -->
                  <div class="tab-pane p-3" id="addOrder" role="tabpanel">
                     <form action="" method="POST" class="customFormInput" id="addOrderForm">
                        <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for=""><strong>Order Details</strong></label>
                                 <input class="form-control datepicker-here" type="text" name="orderDate"
                                    placeholder="<?php echo date('m/d/Y h:i a'); ?>" data-language='en'
                                    data-timepicker="true" />
                              </div>
                              <div class="form-group">
                                 <select class="custom-select" name="user">
                                    <option selected disabled>Please Select..</option>
                                    <?php
                                    if (!empty($fetchUsers) && is_array($fetchUsers)) {
                                       foreach ($fetchUsers as $eachUser) {
                                          echo '<option value="' . $eachUser['id'] . '">' . $eachUser['full_name'] . '</option>';
                                       }
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <input class="form-control bg-white" type="text" readonly id="userEmail" />
                              </div>
                              <div class="form-group">
                                 <input class="form-control bg-white" type="text" readonly id="userMobile" />
                              </div>
                           </div>
                           <div class="col-md-8">
                              <div class="form-group">
                                 <label for=""><strong>Order Item Details</strong></label>
                                 <div class="">
                                    <table class="table table-sm">
                                       <thead>
                                          <tr>
                                             <th scope="col" style="width: 3%;">Sl.</th>
                                             <th scope="col" style="width: 40%;">Service Type</th>
                                             <th scope="col" style="width: 35%;">Product Name</th>
                                             <th scope="col" style="width: 17%;">Price</th>
                                             <th scope="col" style="width: 5%;">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody id="appendRows">
                                          <tr id="contentRow">
                                             <td>
                                                <button class="btn btn-light text-dark waves-effects waves-light"
                                                   type="button">
                                                   <i class="ion-edit"></i>
                                                </button>
                                             </td>
                                             <td>
                                                <select class="custom-select" name="service[]" id="service">
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
                                                <select class="custom-select productName" name="product[]" id="product">
                                                   <option selected>Please Select..</option>
                                                </select>
                                             </td>
                                             <td>
                                                <input type="text" readonly value="" name="price[]"
                                                   class="form-control bg-white font-weight-bold prices" id="price" />
                                             </td>
                                             <td>
                                                <button class="btn btn-success waves-effect waves-light" type="button"
                                                   id="addNewRow">
                                                   <i class="ion-plus-round"></i>
                                                </button>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 offset-md-3">
                              <div class="form-group pt-4">
                                 <button type="submit" name="createOrders"
                                    class="btn btn-primary btn-block waves-effect waves-light">
                                    Confirm &amp; Save
                                 </button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <!-- create a new order list tab -->

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= Add New Order Page Content -End- =+|+= -->

<!-- =+|+= Order Item Details Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="cartItemDetails" aria-labelledby="cartItemDetailsModal"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header mx-3">
            <h5 class="modal-title mt-0">Order Item Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ion-close-round"></i></span>
            </button>
         </div>
         <div id="cartItemDetailList">
            <!-- items data will be appeared here -->
         </div>
      </div>
   </div>
</div>
<!-- =+|+= Order Item Details Modal Content -End- =+|+= -->

<!-- =+|+= Delete Order Cart Modal Content -Start- =+|+= -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteCartData" aria-labelledby="deleteCartDataModal"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="card-body pb-1">
               <h4 class="card-title font-16 mt-0 font-weight-normal">
                  Do your really want to delete this <strong>ShopCart</strong> data?
               </h4>
               <div class="pt-3">
                  <button type="button" class="btn btn-primary waves-effect waves-light px-4" id="confirm">
                     <i class="ion-checkmark-circled"></i> Confirm
                  </button>
                  <button type="button" class="btn btn-light waves-effect m-l-5 px-4" data-dismiss="modal">
                     <i class="ion-close-circled"></i> Close
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= Delete Order Cart Modal Content -End- =+|+= -->

<!-- =+|+= JavaScript Content -Start- =+|+= -->
<script type="text/javascript">
   $(document).ready(function() {

      //Order Items List
      $(document).on('click', '.viewItems', function() {
         let cartID = $(this).data('vid');
         if (cartID !== '') {
            console.log(cartID);
            $.ajax({
               url: 'sync.php',
               type: 'POST',
               data: {
                  action: "ORDER_ITEM_DETAILS",
                  id: cartID
               },
               success: function(data) {
                  console.log(data);
                  $('#cartItemDetailList').html(data);
               }
            });
         }
      });


      //Get Email and Mobile No Based On User Name
      $(document).on('change', '[name="user"]', function(e) {
         let userId = $(this).val();
         if (userId !== null) {
            $.ajax({
               url: 'sync.php',
               type: 'POST',
               data: {
                  action: "GET_USER_DETAILS",
                  id: userId
               },
               success: function(data) {
                  let details = JSON.parse(data);
                  $('#userEmail').val(details[0].email);
                  $('#userMobile').val(details[0].mobile);
               }
            });
         }
      });


      //Get Product Name Based on Service Type
      function getProduct(onChange, getDetails) {
         $(document).on('change', `${onChange}`, function() {
            let getData = $(this).val();

            if (getData !== '') {
               $.ajax({
                  url: 'sync.php',
                  type: 'POST',
                  data: {
                     action: "GET_SERVICE_BASED_PRODUCT",
                     id: getData
                  },
                  success: function(data) {
                     $(`${getDetails}`).html(data);
                  }
               });
            }
         });
      }


      //Get Product Price Based On Product Name
      function productPrice(eventType, onChange, getDetails) {
         $(document).on(`${eventType}`, `${onChange}`, function() {
            let getData = $(this).val();

            if (getData !== '') {
               $.ajax({
                  url: 'sync.php',
                  type: 'POST',
                  data: {
                     action: "GET_PRODUCT_PRICE",
                     id: getData
                  },
                  success: function(data) {
                     $(`${getDetails}`).val(data);
                  }
               });
            } else {
               $(`${getDetails}`).val('');
            }
         });
      }


      //Default Row Values
      getProduct('#service', '#product');
      productPrice('change click', '#product', '#price');


      //Assign a Variable for Increment and Add A New Row
      let n = 1;

      $(document).on('click', '#addNewRow', function() {
         if ($('#price').val() > 0) {
            $('#appendRows').append(addNewRows());
            getProduct('#service' + n, '#product' + n);
            productPrice('change click', '#product' + n, '#price' + n);
            n++;
         }
      });


      //Remove A Row
      $(document).on('click', '.removeRow', function() {
         let deleteId = $(this).attr('did');
         $('#contentRow' + deleteId).fadeOut(300, function() {
            $(this).remove();
         });
      });


      //Empty Form Submission Prevention
      $(document).on('submit', '#addOrderForm', function(e) {
         let price = $('.prices').each(function() {
            if ($(this).val() !== '') {
               return true;
            } else {
               e.preventDefault();
               confirm('Please make sure that all fields are not empty');
               return false;
            }
         });
      });


      //Template Literature for Appending Rows
      function addNewRows() {
         let addNewRows = `
         <tr id="contentRow${n}">
            <td>
               <button class="btn btn-light text-dark waves-effects waves-light" type="button">
                  <i class="ion-edit"></i>
               </button>
            </td>
            <td>
               <select class="custom-select" name="service[]" id="service${n}">
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
               <select class="custom-select productName" name="product[]" id="product${n}">
                  <option selected>Please Select..</option>
               </select>
            </td>
            <td>
               <input type="text" readonly value="" name="price[]" class="form-control bg-white font-weight-bold prices" id="price${n}" />
            </td>
            <td>
               <button class="btn btn-primary waves-effect waves-light removeRow" type="button" did="${n}">
                  <i class="ion-close-round"></i>
               </button>
            </td>
         </tr>
         `;
         return addNewRows;
      }
   });
</script>
<!-- =+|+= JavaScript Content -End- =+|+= -->