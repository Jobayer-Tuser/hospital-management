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
 * Fetch All The Statement Table Data
 * Merge on Condition Based on "Date" Condition
 */
$fetchStatement = $read->columnArray('statement', 'date');
if (!empty($fetchStatement)) {
   $getDatesOnly = $misc->arrayMergeUnique($fetchStatement, 'date', true);
}

?>

<!-- =+|+= Monthly Statement Page Content -Start- =+|+= -->
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
                           <th scope="col">Year</th>
                           <th scope="col">Income Statement</th>
                           <th scope="col">Expenditure Statement</th>
                           <th scope="col">Profit Statement</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        /**
                         * [MONTHLY STATEMENT TABLE]
                         * 
                         * SQL Date Convert Into Between Month First and Last
                         * Read All The Required Data Such As
                         * [1] Expenditure Statement
                         * [2] Income Statement
                         * Profile Calculation Based On Expenditure and Income
                         */
                        if (!empty($getDatesOnly)) {
                           $n = 1;
                           if (is_array($getDatesOnly)) {
                              foreach ($getDatesOnly as $each) {
                                 $eachMonth = $misc->sqlMonthBetween($each);
                                 $eachMonthExp = $read->eachMonthTotal('statement', 'total_amount', 'type', '"Expenditure"', 'date', $eachMonth);
                                 $eachMonthInc = $read->eachMonthTotal('statement', 'total_amount', 'type', '"Income"', 'date', $eachMonth);
                        ?>

                                 <tr>
                                    <td class="font-weight-bold">
                                       <?php echo $n; ?>
                                    </td>
                                    <td>
                                       <?php echo $misc->monthYear($each); ?>
                                    </td>
                                    <td>
                                       <strong><?php echo !empty($eachMonthInc[0]['total']) ? $eachMonthInc[0]['total'] : 0; ?></strong> tk/BDT
                                    </td>
                                    <td>
                                       <strong><?php echo !empty($eachMonthExp[0]['total']) ? $eachMonthExp[0]['total'] : 0; ?></strong> tk/BDT
                                    </td>
                                    <td>
                                       <?php
                                       //Profit Calculation
                                       $evaluation = $eachMonthInc[0]['total'] - $eachMonthExp[0]['total'];
                                       if ($evaluation < 0) {
                                          $profit = $evaluation . '<i class="ion-arrow-down-b text-primary float-right"></i>';
                                       } else {
                                          $profit = $evaluation . '<i class="ion-arrow-up-b text-success float-right"></i>';
                                       }
                                       echo '<strong>' . $profit . '</strong> tk/BDT';
                                       ?>
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
<!-- =+|+= Monthly Statement Page Content -End- =+|+= -->