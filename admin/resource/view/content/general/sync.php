<?php

/**
 * AutoLoad Required Controllers
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 * [2] AdminController
 * [3] CreateController
 * [4] ReadController
 * [5] UpdateController
 * [6] DeleteController
 */
spl_autoload_register(function ($class) {
   if (file_exists('app/Http/Controllers/' . $class . '.php')) {
      include('app/Http/Controllers/' . $class . '.php');
   }
});

$misc = new MiscellaneousController;
$date = new DateController;
$admin = new AdminController;
$create = new CreateController;
$read = new ReadController;
$update = new UpdateController;
$delete = new DeleteController;



/**
 * Common CRUD Operation
 * ------------------------||------------------------
 * [1] To Input Field Validate with Previous Data
 * [2] To Get Delete Data Title
 */

if (@$_POST['action'] === "INPUT_VALIDATION") {
   $fetchData = $read->isExist($_POST['table'], $_POST['column'], $_POST['name']);
   if (!empty($fetchData)) {
      echo 1;
   }
}


if (@$_POST['action'] === "DELETE_DATA") {
   $fetchDeleteDataTitle = $read->column($_POST['deleteFrom'], $_POST['deleteName'], $_POST['did']);
   if (!empty($fetchDeleteDataTitle)) {
      echo $fetchDeleteDataTitle;
   }
}



/**
 * Todo CRUD Operation
 * ------------------------||------------------------
 * [1] Read All
 * [2] Delete A Single Todo Data
 * [1] Create A Single Todo Data
 */

if (@$_POST['action'] === "GET_TODOS_DATA") {
   $fetchAllTodos = $read->findOn('todos', 'user_id', $_POST['id']);
   if (!empty($fetchAllTodos) && is_array($fetchAllTodos)) {
      foreach ($fetchAllTodos as $eachTodos) {
         echo '
            <li class="list-group-item d-flex justify-content-between align-items-center customList">
               ' . $eachTodos['details'] . '
               <span>
                  <a href="javascript:;" class="text-secondary deleteTodos" data-todo="' . $eachTodos['id'] . '">
                     <i class="dripicons-trash"></i>
                  </a>
               </span>
            </li>
         ';
      }
   }
}


if (@$_POST['action'] === "DELETE_TODO_DATA") {
   $deleteTodo = $delete->deleteAll('todos', $_POST['id']);
   if (!empty($deleteTodo)) {
      echo 1;
   }
}


if (@$_POST['action'] === "ADD_TODO_DATA") {
   $createTodo = $create->createTodo($_POST['user'], $_POST['todo']);
   if (!empty($createTodo)) {
      echo 1;
   }
}



/**
 * Comment CRUD Operation
 * ------------------------||------------------------
 * [1] Update Status Data
 */

if (@$_POST['action'] === "CHANGE_PUBLICATION_STATUS") {
   $updateCommentStatus = $update->updateCommentStatus($_POST['status'], $_POST['id']);
   if (!empty($updateCommentStatus)) {
      echo 1;
   }
}



/**
 * Add Statement CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 */

if (@$_POST['action'] === "GET_CATEGORY_ON_TYPE") {
   $fetchCategory = $read->findOn('accounts', 'type', '"' . $_POST['name'] . '"', 'status', '"Active"');
   if (!empty($fetchCategory) && is_array($fetchCategory)) {
      foreach ($fetchCategory as $eachCategory) {
         echo '<option value="' . $eachCategory['id'] . '">' . $eachCategory['title'] . '</option>';
      }
   } else {
      echo '<option>Oops! no records found</option>';
   }
}



/**
 * Expenditure and Income CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 * [2] Delete Data
 */

if (@$_POST['action'] === "DELETE_STATEMENT_DATA") {
   $fetchStatement = $read->findOn('statement', 'id', $_POST['did']);

   $statementDetailsId = [];

   if (!empty($fetchStatement) && is_array($fetchStatement)) {
      foreach ($fetchStatement as $eachStatement) {
         $getStatementDetailsData = $read->findOn('statement_details', 'statement_id', $eachStatement['id']);
      }
      foreach ($getStatementDetailsData as $eachDetails) {
         array_push($statementDetailsId, $eachDetails['id']);
      }
   }

   if (!empty($statementDetailsId) && is_array($statementDetailsId)) {
      $convertString = rtrim(implode(',', $statementDetailsId), ' ');
      $deleteStatementDetails = $delete->deleteMultiple('statement_details', $convertString);
      if ($deleteStatementDetails > 0) {
         $deleteStatement = $delete->deleteAll('statement', $fetchStatement[0]['id']);
         if (!empty($deleteStatement)) {
            echo 1;
         }
      }
   }
}



/**
 * Add Orders CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 */

if (@$_POST['action'] === "GET_USER_DETAILS") {
   $fetchUserDetails = $read->findOn('users', 'id', $_POST['id']);
   $userDetails = null;
   if (!empty($fetchUserDetails) && is_array($fetchUserDetails)) {
      $userDetails = json_encode($fetchUserDetails, JSON_PRETTY_PRINT);
      echo $userDetails;
   }
}


if (@$_POST['action'] === "GET_SERVICE_BASED_PRODUCT") {
   $fetchProduct = $read->findOn('products', 'service_id', $_POST['id'], 'status', '"Active"');

   if (!empty($fetchProduct) && is_array($fetchProduct)) {
      foreach ($fetchProduct as $eachProduct) {
         echo '<option value="' . $eachProduct['id'] . '">' . $eachProduct['title'] . '</option>';
      }
   } else {
      echo '<option value="">Oops! please select</option>';
   }
}


if (@$_POST['action'] === "GET_PRODUCT_PRICE") {
   $fetchProductPrice = $read->findOn('products', 'id', $_POST['id']);

   if (!empty($fetchProductPrice) && is_array($fetchProductPrice)) {
      echo $fetchProductPrice[0]['price'];
   } else {
      echo 0;
   }
}


if (@$_POST['action'] === "ORDER_ITEM_DETAILS") {
   $fetchShopCart = $read->findOn('shopcarts', 'id', $_POST['id']);
   if (!empty($fetchShopCart) && is_array($fetchShopCart)) {
      $orderItemDetails = $read->findOn('order_items', 'shopcart_id', $fetchShopCart[0]['id']);
      if (!empty($orderItemDetails) && is_array($orderItemDetails)) {
         $n = 1;

         echo '
         <div class="modal-body">
            <div class="table-responsive">
               <table class="table table-borderless table-hover">
                  <thead class="thead-dark table-sm">
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Service</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                     </tr>
                  </thead>
                  <tbody>
         ';

         foreach ($orderItemDetails as $eachItems) {
            $service = $read->findOn('services', 'id', $eachItems['service_title']);
            $product = $read->findOn('products', 'id', $eachItems['product_id']);
            $priceUpdate = (!empty($product[0]['updated_at'])) ? $date->dateTime($product[0]['updated_at']) : $date->dateTime($product[0]['created_at']);

            echo '
               <tr>
                  <td class="font-weight-bold">' . $n . '</td>
                  <td>' . $service[0]['title'] . '</td>
                  <td>' . $product[0]['title'] . '</td>
                  <td>' . $product[0]['price'] . '</td>
               </tr>
            ';
            $n++;
         }

         echo '
                  </tbody>
               </table>
            </div>
         </div>
         ';
      }
   }
}



/**
 * Admins CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 */

if (@$_POST['action'] === "ADMIN_PROFILE") {
   $fetchAdminData = $read->findOn('admins', 'id', $_POST['id']);
   if (!empty($fetchAdminData) && is_array($fetchAdminData)) {
      $adminDetails = null;
      foreach ($fetchAdminData as $eachAdmin) {
         if ($eachAdmin['admin_status'] === "Active") {
            $status = '<span class="float-right text-success"><strong>' . $eachAdmin['admin_status'] . '</strong></span>';
         } else {
            $status = '<span class="float-right text-primary"><strong>' . $eachAdmin['admin_status'] . '</strong></span>';
         }
         $adminDetails .= '
            <div class="card-body">
               <div class="row mb-0 mt-2">
                  <div class="col-2">
                     <img class="rounded shadow" width="86" height="86"
                        src="' . $GLOBALS['ADMINS_DIR'] . $eachAdmin['admin_avatar'] . '" />
                  </div>
                  <div class="col-10 text-right">
                     <h4 class="card-title font-18">' . $eachAdmin['admin_name'] . '</h4>
                     <h6 class="card-subtitle font-14 text-muted">
                        <i class="ti-marker-alt"></i> ' . $eachAdmin['admin_role_type'] . '
                     </h6>
                     <h6 class="card-subtitle font-14 text-muted pt-2">' . $status . '</h6>
                  </div>
               </div>
               <div class="my-3">
                  <ul class="list-group">
                     <li class="list-group-item">
                        <div>
                           <span><strong>Mobile:</strong></span>
                           <span class="float-right">+88 ' . $eachAdmin['admin_mobile'] . '</span>
                        </div>
                        <div>
                           <span><strong>Email:</strong></span>
                           <span class="float-right">' . $eachAdmin['admin_email'] . '</span>
                        </div>
                        <div>
                           <span><strong>NID Card No:</strong></span>
                           <span class="float-right">' . $eachAdmin['admin_nidcard_no'] . '</span>
                        </div>
                        <div>
                           <span><strong>Gender:</strong></span>
                           <span class="float-right">' . $eachAdmin['admin_gender'] . '</span>
                        </div>
                        <div>
                           <span><strong>Created Date:</strong></span>
                           <span class="float-right">' . $date->dateTime($eachAdmin['created_at']) . '</span>
                        </div>
                        <div>
                           <span><strong>Updated Date:</strong></span>
                           <span class="float-right">' . $date->dateTime($eachAdmin['updated_at']) . '</span>
                        </div>
                     </li>
                  </ul>
               </div>
               <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                  Close Details
               </button>
            </div>
         ';
      }
      echo $adminDetails;
   }
}



/**
 * Doctors CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 */

if (@$_POST['action'] === "GET_DOCTOR_PROFILE") {
   $fetchDoctorDetails = $read->findOn('doctors', 'id', $_POST['id']);
   if (!empty($fetchDoctorDetails) && is_array($fetchDoctorDetails)) {
      foreach ($fetchDoctorDetails as $eachDoctor) {
         if ($eachDoctor['status'] === "Active") {
            $status = '<span class="float-right text-success"><strong>' . $eachDoctor['status'] . '</strong></span>';
         } else {
            $status = '<span class="float-right text-primary"><strong>' . $eachDoctor['status'] . '</strong></span>';
         }

         echo '
         <div class="card-body">
            <div class="row mb-0 mt-2">
               <div class="col-2">
                  <img class="rounded shadow" width="83" height="83" src="' . $GLOBALS['DOCTORS_DIR'] . $eachDoctor['avatar'] . '" />
               </div>
               <div class="col-10 text-right">
                  <h4 class="card-title font-16" style="margin-top:5px;">' . $eachDoctor['full_name'] . '</h4>
                  <h6 class="card-subtitle font-14 text-secondary"><strong>' . $eachDoctor['specialty'] . '</strong></h6>
                  <h6 class="card-subtitle font-14 text-muted pt-2">' . $eachDoctor['degree'] . '</h6>
                  <h6 class="card-subtitle font-14 text-muted pt-2">' . $eachDoctor['designation'] . '</h6>
                  <h6 class="card-subtitle font-14 text-muted pt-2">' . $eachDoctor['organization'] . '</h6>
                  <h6 class="card-subtitle font-14 text-muted pt-2"><i class="ion-ios7-location text-info pr-2"></i> ' . $eachDoctor['address'] . '</h6>
               </div>
            </div>
            <div class="my-3">
               <ul class="list-group">
                  <li class="list-group-item">
                     <div>
                        <span><strong>Chember</strong></span>
                        <span class="float-right">' . $eachDoctor['chember'] . '</span>
                     </div>
                     <div>
                        <span><strong>Location:</strong></span>
                        <span class="float-right">' . $eachDoctor['location'] . '</span>
                     </div>
                     <div>
                        <span><strong>Mobile:</strong></span>
                        <span class="float-right">+88 ' . $eachDoctor['mobile'] . '</span>
                     </div>
                     <div>
                        <span><strong>Email:</strong></span>
                        <span class="float-right">' . $eachDoctor['email'] . '</span>
                     </div>
                     <div>
                        <span><strong>NID Card No:</strong></span>
                        <span class="float-right">' . $eachDoctor['nid_card_no'] . '</span>
                     </div>
                     <div>
                        <span><strong>Schedule:</strong></span>
                        <span class="float-right">' . $eachDoctor['schedule'] . '</span>
                     </div>
                     <div>
                        <span><strong>Visiting Time:</strong></span>
                        <span class="float-right">
                           ' . $date->time($eachDoctor['start_time']) . ' to ' . $date->time($eachDoctor['end_time']) . '
                        </span>
                     </div>
                     <div>
                        <span><strong>Status:</strong></span>' . $status . '
                     </div>
                     <div>
                        <span><strong>Created Date:</strong></span>
                        <span class="float-right">' . $date->dateTime($eachDoctor['created_at']) . '</span>
                     </div>
                  </li>
               </ul>
            </div>
            <button type="button" class="btn btn-secondary btn-block waves-effect waves-light" data-dismiss="modal" aria-label="Close">
               Close Details
            </button>
         </div>
         ';
      }
   }
}
?>



<?php
/**
 * Department CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 * 
 * Fetch Table Data Such As:
 * [1] Departments
 * [2] Categories
 */

if (@$_POST['action'] === "EDIT_DEPARTMENT_DATA") {
   $fetchDepartment = $read->findOn('departments', 'id', $_POST['eid']);
   $fetchCategory = $read->findOn('categories', 'status', '"Active"', 'type', '"Department"');
   if (!empty($fetchDepartment) && is_array($fetchDepartment)) {
      foreach ($fetchDepartment as $eachDept) {
?>
         <div class="modal-body">
            <form class="customFormInput px-2" action="" method="POST">
               <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
               <input type="hidden" name="update_id" value="<?php echo $eachDept['id']; ?>" />
               <div class="form-group">
                  <label for=""><strong>Category Title</strong></label>
                  <input type="text" class="form-control" name="update_title" value="<?php echo $eachDept['title']; ?>" />
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Name</strong></label>
                  <select class="custom-select" name="update_category">
                     <?php
                     if (!empty($fetchCategory) && is_array($fetchCategory)) {
                        foreach ($fetchCategory as $eachCategory) {
                           echo '<option value="' . $eachCategory['id'] . '"';
                           if ($eachCategory['id'] == $eachDept['category_id'])
                              echo 'selected';
                           echo '>' . $eachCategory['title'] . '</option>';
                        }
                     }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Status</strong></label>
                  <select class="custom-select" name="update_status">
                     <option <?php if ($eachDept['status'] === "Active") echo "selected"; ?>>Active</option>
                     <option <?php if ($eachDept['status'] === "Inactive") echo "selected"; ?>>Inactive</option>
                  </select>
               </div>
               <div class="form-group">
                  <div class="pt-3">
                     <button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="updateDepartment">
                        <i class="ion-plus-circled"></i> Confirm &amp; Update
                     </button>
                     <button type="button" class="btn btn-light text-primary waves-effect m-l-5 px-4" data-dismiss="modal">
                        <i class="ion-close-circled"></i> Close
                     </button>
                  </div>
               </div>
            </form>
         </div>

<?php
      }
   }
}
?>



<?php
/**
 * Service CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 * 
 * Fetch Table Data Such As:
 * [1] Services
 * [2] Categories
 */

if (@$_POST['action'] === "EDIT_SERVICE_DATA") {
   $fetchService = $read->findOn('services', 'id', $_POST['eid']);
   $fetchCategory = $read->findOn('categories', 'status', '"Active"', 'type', '"Services"');
   if (!empty($fetchService) && is_array($fetchService)) {
      foreach ($fetchService as $eachServ) {
?>
         <div class="modal-body">
            <form class="customFormInput px-2" action="" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
               <input type="hidden" name="update_id" value="<?php echo $eachServ['id']; ?>" />
               <div class="form-group">
                  <label for=""><strong>Service Title</strong></label>
                  <input type="text" class="form-control" name="update_title" value="<?php echo $eachServ['title']; ?>" />
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Name</strong></label>
                  <select class="custom-select" name="update_category">
                     <?php
                     if (!empty($fetchCategory) && is_array($fetchCategory)) {
                        foreach ($fetchCategory as $eachCategory) {
                           echo '<option value="' . $eachCategory['id'] . '"';
                           if ($eachCategory['id'] == $eachServ['category_id']) {
                              echo 'selected';
                           }
                           echo '>' . $eachCategory['title'] . '</option>';
                        }
                     }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for=""><strong>Service Status</strong></label>
                  <select class="custom-select" name="update_status">
                     <option <?php if ($eachServ['status'] === "Active") echo "selected"; ?>>Active</option>
                     <option <?php if ($eachServ['status'] === "Inactive") echo "selected"; ?>>Inactive</option>
                  </select>
               </div>
               <div class="form-group">
                  <div class="pt-3">
                     <button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="updateService">
                        <i class="ion-plus-circled"></i> Confirm &amp; Update
                     </button>
                     <button type="button" class="btn btn-light text-primary waves-effect m-l-5 px-4" data-dismiss="modal">
                        <i class="ion-close-circled"></i> Close
                     </button>
                  </div>
               </div>
            </form>
         </div>
<?php
      }
   }
}
?>



<?php
/**
 * Category CRUD Operation
 * ------------------------||------------------------
 * [1] Read Data
 */

if (@$_POST['action'] === "EDIT_CATEGORY_DATA") {
   $fetchCategory = $read->findOn('categories', 'id', $_POST['eid']);
   if (!empty($fetchCategory) && is_array($fetchCategory)) {
      foreach ($fetchCategory as $eachCategory) {
?>
         <div class="modal-body">
            <form class="customFormInput px-2" action="" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="_token" value="<?php echo $misc->unique(); ?>" />
               <input type="hidden" name="update_id" value="<?php echo $eachCategory['id']; ?>" />
               <div class="form-group">
                  <label for=""><strong>Category Title</strong></label>
                  <input type="text" class="form-control" name="update_title" value="<?php echo $eachCategory['title']; ?>" />
               </div>
               <div class="form-group">
                  <label for=""><strong>Type of Category</strong></label>
                  <div class="custom-control custom-radio">
                     <input type="radio" id="customRadio3" name="update_type" value="Services" class="custom-control-input" disabled <?php if ($eachCategory['type'] === "Services") echo 'checked'; ?> />
                     <label class="custom-control-label" for="customRadio3">
                        All kind of services except doctor department
                     </label>
                  </div>
                  <div class="custom-control custom-radio">
                     <input type="radio" id="customRadio4" name="update_type" value="Department" class="custom-control-input" disabled <?php if ($eachCategory['type'] === "Department") echo 'checked'; ?> />
                     <label class="custom-control-label" for="customRadio4">
                        Or only for doctor departments
                     </label>
                  </div>
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Status</strong></label>
                  <select class="custom-select" name="update_status">
                     <option <?php if ($eachCategory['status'] === "Active") echo "selected"; ?>>
                        Active
                     </option>
                     <option <?php if ($eachCategory['status'] === "Inactive") echo "selected"; ?>>
                        Inactive
                     </option>
                  </select>
               </div>
               <div class="form-group">
                  <label for=""><strong>Category Icon or Logo</strong></label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <button class="btn btn-secondary" type="button" id="uploadIcon">
                           <i class="mdi mdi-cloud-upload"></i>
                        </button>
                     </div>
                     <div class="custom-file">
                        <input type="file" class="custom-file-input imageFile" name="logo" aria-describedby="uploadIcon""/>
                        <label class=" custom-file-label fileName" for="avatar">
                        <?php echo (!empty($eachCategory['logo']) ? $eachCategory['logo'] : 'Choose File'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="pt-3">
                     <button type="submit" class="btn btn-light text-success waves-effect waves-light px-4" name="updateCategory">
                        <i class="ion-plus-circled"></i> Confirm &amp; Update
                     </button>
                     <button type="button" class="btn btn-light text-primary waves-effect m-l-5 px-4" data-dismiss="modal">
                        <i class="ion-close-circled"></i> Close
                     </button>
                  </div>
               </div>
            </form>
         </div>
<?php
      }
   }
}
?>