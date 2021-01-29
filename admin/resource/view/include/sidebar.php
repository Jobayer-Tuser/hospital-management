<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] ReadController
 */
$misc = new MiscellaneousController;
$read = new ReadController;



/**
 * [Read Data]
 */
$ordersCount = $read->countTotal('shopcarts', 'id', 'date', '"' . date('Y-m-d') . '"');
$appointmentCount = $read->countTotal('appointment_request', 'id');

?>

<!-- =+|+= Application SideBar Content [Start] =+|+= -->
<div class="left side-menu">
   <div class="slimscroll-menu" id="remove-scroll">
      <div id="sidebar-menu">
         <ul class="metismenu" id="side-menu">
            <li class="menu-title">Main</li>
            <li>
               <a href="dashboard" class="waves-effect">
                  <i class="fas fa-chart-line"></i> Dashboard
               </a>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-user-secret"></i>
                  <span> Manage Admin
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li><a href="add-admin">Add Admin</a></li>
                  <li><a href="admins">Admin List</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-user-md"></i>
                  <span> Manage Doctor
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li><a href="add-doctor">Add Doctor</a></li>
                  <li><a href="doctors">Doctor List</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-users"></i>
                  <span> Manage User
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li><a href="users">Users</a></li>
                  <li><a href="comments">Comments</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-cogs"></i>
                  <span> Manage Application
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li><a href="categories">Categories</a></li>
                  <li><a href="departments">Departments</a></li>
                  <li><a href="services">Services</a></li>
                  <li><a href="products">Add Products</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-university"></i>
                  <span> Manage Accounts
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li><a href="add-statement">Add New Statement</a></li>
                  <li><a href="expenditure">Expenditure Statement</a></li>
                  <li><a href="income">Income Statement</a></li>
                  <li><a href="monthly">Monthly Statement</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-shopping-cart"></i>
                  <span> Manage Orders
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li>
                     <a href="add-orders">
                        <span class="badge badge-success float-right">
                           <?php echo $ordersCount[0]['total']; ?>
                        </span> New Orders
                     </a>
                  </li>
                  <li><a href="orders">Order List</a></li>
               </ul>
            </li>
            <li>
               <a href="javascript:void(0);" class="waves-effect">
                  <i class="fas fa-procedures"></i>
                  <span> Manage Appointment
                     <span class="float-right menu-arrow">
                        <i class="mdi mdi-plus"></i>
                     </span>
                  </span>
               </a>
               <ul class="submenu">
                  <li>
                     <a href="make-appointment">
                        <span class="badge badge-success float-right">
                           <?php echo $appointmentCount[0]['total']; ?>
                        </span> Make Appointment
                     </a>
                  </li>
                  <li><a href="appointments">Appointments</a></li>
               </ul>
            </li>
         </ul>
      </div>
   </div>
</div>
<!-- =+|+= Application SideBar Content [End] =+|+= -->