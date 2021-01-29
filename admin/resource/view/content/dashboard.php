<?php

# =*|*=[ OBJECT DEFINED ]=*|*=
$misc = new MiscellaneousController;
$comp = new ComponentController;
$read = new ReadController;


# =*|*=[ READ DATA ]=*|*=
/**
 * Read Expenditure Data
 * Read Income Data
 * Assign Variables and Convert Expenditure and Income Data Into a Required Donut Chart Data
 */
$getExpenditureData = $read->calculateTotal(
   'statement',
   'total_amount',
   'type',
   '"Expenditure"'
);

$getIncomeData = $read->calculateTotal(
   'statement',
   'total_amount',
   'type',
   '"Income"'
);

$label = ["Income", "Expense", "Profit"];
$value = [];

$incomeTotal = !empty($getIncomeData[0]['total']) ? $getIncomeData[0]['total'] : 0;
$expenditureTotal = !empty($getExpenditureData[0]['total']) ? $getExpenditureData[0]['total'] : 0;
$profitTotal = (int) $incomeTotal - (int) $expenditureTotal;

array_push($value, $incomeTotal);
array_push($value, $expenditureTotal);
array_push($value, $profitTotal);

$donutChart = null;

for ($i = 0; $i < count($label); $i++) {
   $donutChart .= '{label: "' . $label[$i] . '", value: ' . $value[$i] . '}, ';
}

$donutChart = rtrim($donutChart, ', ');



/**
 * [Summary Card Data]
 * 
 * Read and Condition Render Based On User Data
 * Read and Condition Render Based On Doctor Data
 * Read and Condition Render Based On Category Data
 * Read and Condition Render Based On Department Data
 * 
 */
$getUserData = $read->countTotal('users', 'id');
$getDoctorData = $read->countTotal('doctors', 'id');
$getCategoryData = $read->countTotal('categories', 'id');
$getDepartmentData = $read->countTotal('departments', 'id');
$getServiceData = $read->countTotal('services', 'id');
$getOrderData = $read->countTotal('shopcarts', 'id', 'date', '"' . date('Y-m-d') . '"');
$getSalesData = $read->sumTotalOn('shopcarts', 'price_total', 'date', '"' . date('Y-m-d') . '"', 'status', '"Completed"');
$getAppointmentData = $read->countTotal('appointments', 'id', 'date', '"' . date('Y-m-d') . '"');

$userTotal = (!empty($getUserData[0]['total'])) ? $getUserData[0]['total'] : 'Not Yet';
$doctorTotal = (!empty($getDoctorData[0]['total'])) ? $getDoctorData[0]['total'] : 'Not Yet';
$categoryTotal = (!empty($getCategoryData[0]['total'])) ? $getCategoryData[0]['total'] : 'Not Yet';
$departmentTotal = (!empty($getDepartmentData[0]['total'])) ? $getDepartmentData[0]['total'] : 'Not Yet';
$serviceTotal = (!empty($getServiceData[0]['total'])) ? $getServiceData[0]['total'] : 'Not Yet';
$orderTotal = (!empty($getOrderData[0]['total'])) ? $getOrderData[0]['total'] : 'Not Yet';
$salesTotal = (!empty($getSalesData[0]['total'])) ? $getSalesData[0]['total'] : 'Not Yet';
$appointmentTotal = (!empty($getAppointmentData[0]['total'])) ? $getAppointmentData[0]['total'] : 'Not Yet';



/**
 * [ Yearly Statement Line Chart Data ]
 * 
 * Read Each Year Name
 * Read Each Year Base Order Statement
 * Read Each Year Base Sales Statement
 * Read Each Year Base Appointment Statement
 */

$years = [];
$monthlyOrderTotal = [];
$monthlySalesTotal = [];
$monthlyAppointmentTotal = [];

for ($i = date('Y', strtotime('-8 years')); $i <= date('Y'); $i++) {
   array_push($years, $i);

   //Order Cart Statement
   $readMonthlyOrderCartStatement = $read->calculateTotal(
      'inventory',
      'price',
      'date',
      $misc->sqlYearBetween($i)
   );

   foreach ($readMonthlyOrderCartStatement as $each) {
      if (!empty($each['total'])) {
         $total = $each['total'];
      } else {
         $total = 0;
      }
      array_push($monthlyOrderTotal, $total);
   }


   //Sales Statement
   $readMonthlySalesStatement = $read->eachMonthTotal(
      'shopcarts',
      'price_total',
      'status',
      '"Completed"',
      'date',
      $misc->sqlYearBetween($i)
   );

   foreach ($readMonthlySalesStatement as $each) {
      if (!empty($each['total'])) {
         $total = $each['total'];
      } else {
         $total = 0;
      }
      array_push($monthlySalesTotal, $total);
   }


   //Appointment Statement
   $readMonthlyAppointmentStatement = $read->calculateTotal(
      'statement',
      'total_amount',
      'isAppointment',
      '"Yes"',
      'date',
      $misc->sqlYearBetween($i)
   );

   foreach ($readMonthlyAppointmentStatement as $each) {
      if (!empty($each['total'])) {
         $total = $each['total'];
      } else {
         $total = 0;
      }
      array_push($monthlyAppointmentTotal, $total);
   }
}



//Line Chart Data Structure
$lineChart = null;
for ($i = 0; $i < count($years); $i++) {
   $lineChart .= "{year:'" . $years[$i] . "', order: " . $monthlyOrderTotal[$i] . ", appoint: " . $monthlyAppointmentTotal[$i] . "},";
}
$lineChart = rtrim($lineChart, ", ");



/**
 * [Grand Total Statement for Order and Sales and Appointment]
 */
$getOrderCartTotal = $read->calculateTotal('inventory', 'price');
$orderGrandTotal = (!empty($getOrderCartTotal[0]['total'])) ? $getOrderCartTotal[0]['total'] : 'Not Yet';
$getAppointmentTotal = $read->calculateTotal('statement', 'total_amount', 'isAppointment', '"Yes"');
$appointmentGrandTotal = (!empty($getAppointmentTotal[0]['total'])) ? $getAppointmentTotal[0]['total'] : 'Not Yet';



/**
 * [ Monthly Accounts Statement Bar Chart Data ]
 * 
 * Read Each Month Name
 * Read Each Month Base Income Statement
 * Read Each Month Base Expenditure Statement
 * Read Each Month Base Profit Statement
 */
$months = [];
$monthlyIncomeTotal = [];
$monthlyExpenseTotal = [];

for ($i = 1; $i <= 12; $i++) {
   $getMonthName = date('M', strtotime("+" . $i . "months"));
   array_push($months, $getMonthName);

   //Income Statement
   $readMonthlyIncomeStatement = $read->eachMonthTotal(
      'statement',
      'total_amount',
      'type',
      '"Income"',
      'date',
      $misc->sqlMonthBetween($getMonthName)
   );

   foreach ($readMonthlyIncomeStatement as $each) {
      if (!empty($each['total'])) {
         $total = $each['total'];
      } else {
         $total = 0;
      }
      array_push($monthlyIncomeTotal, $total);
   }


   //Expenditure Statement
   $readMonthlyExpenseStatement = $read->eachMonthTotal(
      'statement',
      'total_amount',
      'type',
      '"Expenditure"',
      'date',
      $misc->sqlMonthBetween($getMonthName)
   );

   foreach ($readMonthlyExpenseStatement as $each) {
      if (!empty($each['total'])) {
         $total = $each['total'];
      } else {
         $total = 0;
      }
      array_push($monthlyExpenseTotal, $total);
   }
}

//Bar Chart Data Structure
$barChart = null;
for ($i = 0; $i < count($months); $i++) {
   $barChart .= "{month:'" . $months[$i] . "', income:" . $monthlyIncomeTotal[$i] . ", expense:" . $monthlyExpenseTotal[$i] . ", profit:" . ($monthlyIncomeTotal[$i] - $monthlyExpenseTotal[$i]) . "},";
}
$barChart = rtrim($barChart, ', ');

?>

<!-- =+|+= DASHBOARD PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">

   <div class="row">
      <?php
      /**
       * Dynamic Summary Card Data
       * All The Card Desing is Render From Component Controller
       */
      echo $comp->dashboardSummary('primary', 'users', $userTotal, 'total user', 'mdi mdi-account-group');
      echo $comp->dashboardSummary('secondary', 'doctor', $doctorTotal, 'total doctor', 'mdi mdi-account');
      echo $comp->dashboardSummary('success', 'category', $categoryTotal, 'total category', 'mdi mdi-buffer');
      echo $comp->dashboardSummary('info', 'section', $departmentTotal, 'total department', 'mdi mdi-apps');
      echo $comp->dashboardSummary('danger', 'service', $serviceTotal, 'total services', 'mdi mdi-cast');
      echo $comp->dashboardSummary('warning', 'orders', $orderTotal, 'today orders', 'mdi mdi-basket');
      echo $comp->dashboardSummary('primary', 'sales', $salesTotal, 'today sales', 'mdi mdi-cart-outline');
      echo $comp->dashboardSummary('dark', 'appoint', $appointmentTotal, 'today appointment', 'mdi mdi-account-plus');
      ?>
   </div>

   <div class="row">
      <!-- Sales Report Graph Content Start -->
      <div class="col-md-9">
         <div class="card">
            <div class="card-body">
               <h4 class="mt-0 header-title text-secondary text-center">
                  Order and Sales and Appointment Overview
               </h4>
               <div class="row pt-3">
                  <div class="col-10">
                     <div id="lineChartStatus" class="morris-chart-height morris-charts"></div>
                  </div>
                  <div class="col-2">
                     <ul class="list-group">
                        <li class="list-inline-item text-primary">
                           <h5 class="mb-0"><?php echo $orderGrandTotal; ?></h5>
                           <p class="font-weight-bold">Orders</p>
                        </li>
                        <li class="list-inline-item text-info">
                           <h5 class="mb-0"><?php echo $appointmentGrandTotal; ?></h5>
                           <p class="font-weight-bold">Appointment</p>
                        </li>
                        <li class="list-inline-item text-muted">
                           <p>
                              Above this Statement is belongs to every <strong>Eight Years Total Orders &amp; Appointment</strong> based
                           </p>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Sales Report Graph Content End -->

      <!-- Total Account Balance Statement Graph Content Start -->
      <div class="col-xl-3">
         <div class="card">
            <div class="card-body">
               <h4 class="mt-0 header-title mb-4 text-secondary text-center">
                  Accounts Total Overview
               </h4>
               <div id="accountStatement" class="dashboard-charts morris-charts"></div>
            </div>
         </div>
      </div>
      <!-- Total Account Balance Statement Graph Content End -->

      <!-- Monthly Accounts Statement Bar Graph Chart Content Start -->
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <h4 class="mt-0 header-title mb-4 text-secondary text-center">
                  Monthly Accounts Income and Expenditure and Profite Statement Overview
               </h4>
               <div id="anotherChart" class="morris-chart-height morris-charts"></div>
            </div>
         </div>
      </div>
      <!-- Monthly Accounts Statement Bar Graph Chart Content End -->

   </div>
</div>
<!-- =+|+= DASHBOARD PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script src="<?php $misc->asset('plugins/raphael/raphael-min.js'); ?>"></script>
<script src="<?php $misc->asset('plugins/morris/morris.min.js'); ?>"></script>

<script type="text/javascript">
   $(document).ready(function() {
      //Order Sales and Appointment Line Chart
      new Morris.Line({
         element: 'lineChartStatus',
         data: [<?php echo $lineChart; ?>],
         xkey: 'year',
         ykeys: ['order', 'appoint'],
         labels: ['Orders', 'Appointment'],
         lineColors: ['#F16C45', '#28BBE3'],
         hideHover: 'auto',
         resize: true
      });

      //Account Statement Donut Chart
      new Morris.Donut({
         element: 'accountStatement',
         data: [<?php echo $donutChart; ?>],
         labelColor: '#5b626b',
         resize: true,
         colors: ['#f5b225', '#FF7300', '#4db6ac']
      });

      //Monthly Account Statement Bars Chart
      new Morris.Bar({
         element: 'anotherChart',
         data: [<?php echo $barChart; ?>],
         xkey: 'month',
         ykeys: ['income', 'expense', 'profit'],
         stacked: false,
         labels: ['Income', 'Expense', 'Profit'],
         hideHover: 'auto',
         barSizeRatio: 0.4,
         resize: true,
         axes: true,
         stacked: false,
         gridLineColor: '#eeeeee',
         // barColors: ['#9575cd', '#4dd0e1', '#ffb74d']
      });
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->