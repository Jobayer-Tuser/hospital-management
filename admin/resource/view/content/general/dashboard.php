<?php

/**
 * ----------------------------------------
 * Object Defined
 * ----------------------------------------
 * 1. Resource Controller
 * 2. Date Controller
 * 3. Component Controller
 * 4. Read Controller
 */
$resc = new ResourceController;
$date = new DateController;
$comp = new ComponentController;
$read = new ReadController;



/**
 * ----------------------------------------
 * Summary Card Data
 * ----------------------------------------
 * 1. Users Total
 * 2. Doctors Total
 * 3. Categories Total
 * 4. Departments Total
 * 5. Services Total
 * 6. Orders Total
 * 7. Sales Total
 * 8. Appointments Total
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
 * ----------------------------------------
 * Grand Total Statement
 * ----------------------------------------
 * 1. Order Total
 * 2. Appointment Total
 */
$orderInv = $read->calculateTotal('inventory', 'price');
$appointmentInv = $read->calculateTotal('statement', 'total_amount', 'isAppointment', '"Yes"');
if (!empty($orderInv) || !empty($appointmentInv)) {
	$orderGrandTotal = (!empty($orderInv[0]['total'])) ? $orderInv[0]['total'] : 'Not Yet';
	$appointmentGrandTotal = (!empty($appointmentInv[0]['total'])) ? $appointmentInv[0]['total'] : 'Not Yet';
}



/**
 * ----------------------------------------
 * Line Chart Data
 * ----------------------------------------
 * 1. Assign Required Variable and Arrays
 * 2. Condition Redering to Prevent Null Value
 * 3. Get All Values and Push it into Empty Array
 * 4. Convert as JavaScript Object String
 */
$lineChart = null;
$endDate = date('Y', strtotime('-8 years'));
$years = [];
$yearlyOrder = [];
$yearlyAppointment = [];

for ($i = $endDate; $i < date('Y'); $i++) {
	array_push($years, $i);
	//Order Cart Statement
	$orders = $read->calculateTotal('inventory', 'price', 'date', $date->sqlYearBetween($i));
	foreach ($orders as $each) {
		$total = (!empty($each['total']) ? $each['total'] : 0);
		array_push($yearlyOrder, $total);
	}

	//Appointment Statement
	$appointments = $read->calculateTotal('statement', 'total_amount', 'isAppointment', '"Yes"', 'date', $date->sqlYearBetween($i));
	foreach ($appointments as $each) {
		$total = (!empty($each['total']) ? $each['total'] : 0);
		array_push($yearlyAppointment, $total);
	}
}

for ($i = 0; $i < count($years); $i++) {
	$lineChart .= "{year:'" . $years[$i] . "', order: " . $yearlyOrder[$i] . ", appoint: " . $yearlyAppointment[$i] . "},";
}

$lineChart = rtrim($lineChart, ", ");



/**
 * ----------------------------------------
 * Donut Chart Data
 * ----------------------------------------
 * 1. Assign Required Variable and Arrays
 * 2. Condition Redering to Prevent Null Value
 * 3. Get All Values and Push it into Empty Array
 * 4. Convert as JavaScript Object String
 */
$donutChart = null;
$donutLabel = ["Income", "Expense", "Profit"];
$donutValue = [];

$donutExpenditure = $read->calculateTotal('statement', 'total_amount', 'type', '"Expenditure"');
$donutIncome = $read->calculateTotal('statement', 'total_amount', 'type', '"Income"');

if (!empty($donutExpenditure) || !empty($donutIncome)) {
	$donutIncomeTotal = !empty($donutIncome[0]['total']) ? $donutIncome[0]['total'] : 0;
	$donutExpenditureTotal = !empty($donutExpenditure[0]['total']) ? $donutExpenditure[0]['total'] : 0;
	$donutProfitTotal = (int) $donutIncomeTotal - (int) $donutExpenditureTotal;

	array_push($donutValue, $donutIncomeTotal);
	array_push($donutValue, $donutExpenditureTotal);
	array_push($donutValue, $donutProfitTotal);

	for ($i = 0; $i < count($donutLabel); $i++) {
		$donutChart .= '{label: "' . $donutLabel[$i] . '", value: ' . $donutValue[$i] . '}, ';
	}
}

$donutChart = rtrim($donutChart, ', ');



/**
 * ----------------------------------------
 * Bar Chart Data
 * ----------------------------------------
 * 1. Assign Required Variable and Arrays
 * 2. Get Each Month Total Using Loop
 * 3. Convert as JavaScript Object String
 */
$barChart = null;
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$monthlyIncomeTotal = [];
$monthlyExpenseTotal = [];

for ($i = 0; $i < count($months); $i++) {
	//Income Statement
	$incomeStatement = $read->eachMonthTotal('statement', 'total_amount', 'type', '"Income"', 'month',  '"' . $months[$i] . '"');
	foreach ($incomeStatement as $each) {
		$total = (!empty($each['total']) ? $each['total'] : 0);
		array_push($monthlyIncomeTotal, $total);
	}
	
	//Expenditure Statement
	$expenseStatement = $read->eachMonthTotal('statement', 'total_amount', 'type', '"Expenditure"', 'month', '"' . $months[$i] . '"');
	foreach ($expenseStatement as $each) {
		$total = (!empty($each['total']) ? $each['total'] : 0);
		array_push($monthlyExpenseTotal, $total);
	}

	$barChart .= "{month:'" . $months[$i] . "', income:" . $monthlyIncomeTotal[$i] . ", expense:" . $monthlyExpenseTotal[$i] . ", profit:" . ($monthlyIncomeTotal[$i] - $monthlyExpenseTotal[$i]) . "},";
}

$barChart = rtrim($barChart, ', ');

?>

<!-- || =+|+= DASHBOARD PAGE CONTENT -START- =+|+= || -->
<div class="page-content-wrapper">
	<div class="row">
		<?php
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
	</div>
</div>
<!-- || =+|+= DASHBOARD PAGE CONTENT -END- =+|+= || -->


<!-- || =+|+= JAVASCRIPT CONTENT -START- =+|+= || -->
<script src="<?php echo $resc->asset('raphael-min.js', 'plugins/raphael'); ?>"></script>
<script src="<?php echo $resc->asset('morris.min.js', 'plugins/morris'); ?>"></script>
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
<!-- || =+|+= JAVASCRIPT CONTENT -END- =+|+= || -->