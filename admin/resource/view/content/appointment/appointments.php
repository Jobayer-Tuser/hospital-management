<?php

/**
 * [ Object Defined ]
 * 
 * Accessible to the Class Methods Such as:
 * [1] Controller
 * [2] MiscellaneousController
 * [3] ReadController
 */
$misc = new MiscellaneousController;
$read = new ReadController;


/**
 * [Read Data]
 * 
 * Fetch All The Appointment Data
 */
$fetchAppointments = $read->all('appointments', true);

?>

<!-- =+|+= Appointments Page Content -Start- =+|+= -->
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
                           <th scope="col">Full Name</th>
                           <th scope="col">Email</th>
                           <th scope="col">Mobile</th>
                           <th scope="col">Appointment On</th>
                           <th scope="col">Doctor Name</th>
                           <th scope="col">Department</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                        if (!empty($fetchAppointments) && is_array($fetchAppointments)) {
                           $n = 1;
                           foreach ($fetchAppointments as $each) {
                        ?>

                              <tr>
                                 <td class="font-weight-bold"><?php echo $n; ?></td>
                                 <td><?php echo $each['user_name']; ?></td>
                                 <td><?php echo $each['user_email']; ?></td>
                                 <td>+88 <?php echo $each['user_phone']; ?></td>
                                 <td><?php echo $misc->dateTime($each['date_time']); ?></td>
                                 <td><?php echo $each['doctor_name']; ?></td>
                                 <td><?php echo $each['department']; ?></td>
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
<!-- =+|+= Appointments Page Content -End- =+|+= -->