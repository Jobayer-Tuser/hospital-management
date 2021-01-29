<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 */
$resc = new ResourceController;
$date = new DateController;

?>

<style type="text/css">
   /* Required Styles For Todo Only */
   .list-group-item {
      padding-top: 8px;
      padding-bottom: 8px;
      font-size: 14.5px;
   }

   .form-control {
      font-size: 14.5px;
   }
</style>


<!-- =+|+= Application Header Content [Start] =+|+= -->
<div class="topbar">
   <div class="topbar-left">
      <a href="dashboard" class="logo">
         <span>
            <img src="<?php echo $resc->asset('logo.png'); ?>" alt="" height="24">
         </span>
         <i>
            <img src="<?php echo $resc->asset('logo-sm.png'); ?>" alt="" height="22">
         </i>
      </a>
   </div>
   <nav class="navbar-custom">
      <ul class="navbar-right d-flex list-inline float-right mb-0">
         <li class="dropdown notification-list">
            <div class="dropdown notification-list nav-pro-img">
               <a href="javascript:void();"
                  class="dropdown-toggle nav-link arrow-none waves-effect nav-user waves-light" data-toggle="dropdown"
                  role="button" aria-haspopup="false" aria-expanded="false">
                  <img src="<?php echo $GLOBALS['ADMINS_DIR'] . $_SESSION['auth_log_image']; ?>" alt="user"
                     class="rounded-circle">
               </a>
               <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                  <a class="dropdown-item" href="#todoData" data-toggle="modal">
                     <i class="far fa-list-alt"></i> Todo Note
                  </a>
                  <a class="dropdown-item" href="?exit=LogOutAdmin">
                     <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
               </div>
            </div>
         </li>
      </ul>
      <ul class="list-inline menu-left mb-0">
         <li class="float-left">
            <button class="button-menu-mobile open-left waves-effect waves-light">
               <i class="mdi mdi-menu"></i>
            </button>
         </li>
         <li class="d-none d-sm-block">
            <div class="pt-3 d-inline-block">
               <button class="btn btn-light waves-effect font-weight-bold">
                  <i class="mdi mdi-alarm-snooze mr-1"></i>
                  <span id="time"></span>
               </button>
            </div>
            <div class="pt-3 d-inline-block">
               <a class="btn btn-light waves-effect" href="javascript:;">
                  <i class="mdi mdi-account-convert mr-1"></i>
                  <strong><?php echo $_SESSION['auth_log_name']; ?></strong>
               </a>
            </div>
            <div class="pt-3 d-inline-block">
               <a class="btn btn-light waves-effect" href="javascript:;">
                  <i class="mdi mdi-alarm-bell mr-1"></i>
                  <strong><?php echo $date->timeElapsed($_SESSION['auth_log_time'], true); ?></strong>
               </a>
            </div>
         </li>
      </ul>
   </nav>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="todoData" aria-labelledby="todoDataModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="modal-header py-2">
               <h5 class="modal-title mt-0">My Todo Note List</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><i class="ion-close-round"></i></span>
               </button>
            </div>
            <div class="card mb-0">
               <div class="card-body">
                  <ul class="list-group" id="todoList">
                     <!-- All The Todos Data Appeared Here -->
                  </ul>
                  <div class="d-flex pt-3">
                     <div class="input-group">
                        <input type="text" class="form-control" id="todoTitle" />
                        <div class="input-group-append">
                           <button class="btn btn-dark waves-effect waves-light" id="addTodos">
                              <i class="ti-pencil-alt"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= Application Header Content [End] =+|+= -->