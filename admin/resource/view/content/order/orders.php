<?php

/**
 * [Object Defined]
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ReadController
 */
$misc = new MiscellaneousController;
$read = new ReadController;


/**
 * [Read Data]
 * 
 * Fetch All The Inventroy Data
 */
$fetchInventory = $read->all('inventory', true);

?>

<!-- =+|+= Order List Page Content -Start- =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="pt-3">
                  <table class="table dt-responsive nowrap datatable"
                     style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Date</th>
                           <th scope="col">User Name</th>
                           <th scope="col">User Email</th>
                           <th scope="col">User Mobile</th>
                           <th scope="col">Service</th>
                           <th scope="col">Product Title</th>
                           <th scope="col">Price</th>
                           <th scope="col">Purchase On</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        /**
                         * Assign a Variable for Auto Increment Based on Condition
                         */
                        if (!empty($fetchInventory) && is_array($fetchInventory)) {
                           $n = 1;
                           foreach ($fetchInventory as $each) {
                        ?>

                              <tr>
                                 <td class="font-weight-bold"><?php echo $n; ?></td>
                                 <td><?php echo $misc->monthYear($each['date']); ?></td>
                                 <td><?php echo $each['name']; ?></td>
                                 <td><?php echo $each['email']; ?></td>
                                 <td>+88 <?php echo $each['mobile']; ?></td>
                                 <td><?php echo $each['service']; ?></td>
                                 <td><?php echo $each['product']; ?></td>
                                 <td><strong><?php echo $each['price']; ?></strong> tk/BDT</td>
                                 <td><?php echo $misc->dateTime($each['created_at']); ?></td>
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
<!-- =+|+= Order List Page Content -End- =+|+= -->