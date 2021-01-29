<?php

class CreateController extends MiscellaneousController
{
   /**
    * Create A New Todo Data
    * 
    * @param string
    * @return int
    */
   public function createTodo($user_id, $text)
   {
      $sql_code = "INSERT INTO `todos` (
            `user_id`, `details`, `created_at`
         ) 
         VALUES (
            :U_ID, :T_DETAILS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':U_ID'        => $user_id,
         ':T_DETAILS'   => $this->encode($text),
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A User Data
    *
    * @param string
    * @return int
    */
   public function addUser($name, $mobile, $email, $password)
   {
      $sql_code = "INSERT INTO `users` (
            `user_id`, `full_name`, `mobile`, `email`, `password`, `status`, `created_at`
         ) 
         VALUES (
            :U_ID, :U_FULL_NAME, :U_MOBILE, :U_EMAIL, :U_PASSWORD, :U_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':U_ID'          => $this->unique(),
         ':U_FULL_NAME'   => $this->encode($name),
         ':U_MOBILE'      => $this->encode($mobile),
         ':U_EMAIL'       => $this->encode(filter_var($email, FILTER_VALIDATE_EMAIL)),
         ':U_PASSWORD'    => $this->encrypt($password),
         ':U_STATUS'      => "Active",
         ':CREATED_AT'    => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A User Comments
    *
    * @param string
    * @return int
    */
   public function addComments($user_id, $commentDetails)
   {
      $sql_code = "INSERT INTO `comments` (
            `user_id`, `comments`, `status`, `created_at`
         ) 
         VALUES (
            :U_ID, :C_COMMENTS, :C_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':U_ID'        => $user_id,
         ':C_COMMENTS'  => $this->encode(addslashes($commentDetails)),
         ':C_STATUS'    => 'Pending',
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A Accounts Data
    *
    * @param string
    * @return int
    */
   public function createAccount($title, $type, $status)
   {
      $sql_code = "INSERT INTO `accounts` (
            `title`, `type`, `status`, `created_at`
         ) 
         VALUES (
            :A_TITLE, :A_TYPE, :A_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':A_TITLE'     => $this->encode($title),
         ':A_TYPE'      => $this->encode($type),
         ':A_STATUS'    => $this->encode($status),
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A New Statement Data
    *
    * @param string
    * @return int
    */
   public function createStatement($date, $type, $account_id, $prepared, $issued, $approved, $description, $total, $isAppointment)
   {
      $sql_code = "INSERT INTO `statement` (
            `date`, `type`, `account_id`, `prepared_on`, `issued_by`, `approved`, `description`, `total_amount`, `isAppointment`, `created_at`
         ) 
         VALUES (
            :DATES, :A_TYPE, :A_ID, :PREPARED_ON, :ISSUED, :APPROVED, :DESCRIPTIONS, :TOTAL_AMOUNT, :IS_APPOINTMENT, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':DATES'          => $date,
         ':A_TYPE'         => $this->encode($type),
         ':A_ID'           => $account_id,
         ':PREPARED_ON'    => $prepared,
         ':ISSUED'         => $this->encode($issued),
         ':APPROVED'       => $approved,
         ':DESCRIPTIONS'   => $this->encode(addslashes($description)),
         ':TOTAL_AMOUNT'   => $total,
         ':IS_APPOINTMENT' => $isAppointment,
         ':CREATED_AT'     => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $lastInsertId;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A New Statement Details Data
    *
    * @param string
    * @return int
    */
   public function createStatementDetails($type, $statement_id, $purpose, $net, $vat, $total)
   {
      $sql_code = "INSERT INTO `statement_details` (
            `type`, `statement_id`, `purpose`, `net_amount`, `vat_amount`, `total_amount`, `created_at`
         ) 
         VALUES (
            :A_TYPE, :STATEMENT_ID, :PURPOSE, :NET, :VAT, :TOTAL_AMOUNT, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':A_TYPE'         => $this->encode($type),
         ':STATEMENT_ID'   => $statement_id,
         ':PURPOSE'        => $this->encode($purpose),
         ':NET'            => $net,
         ':VAT'            => $vat,
         ':TOTAL_AMOUNT'   => $total,
         ':CREATED_AT'     => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A New Category Data
    *
    * @param string
    * @return int
    */
   public function createCategory($title, $type, $logo, $path, $status)
   {
      $sql_code = "INSERT INTO `categories` (
            `title`, `type`, `logo`, `path`, `status`, `created_at`
         ) 
         VALUES (
            :C_TITLE, :C_TYPE, :C_LOGO, :F_PATH, :C_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':C_TITLE'     => $this->encode($title),
         ':C_TYPE'      => $type,
         ':C_LOGO'      => $this->encode($logo),
         ':F_PATH'      => $this->encode($path),
         ':C_STATUS'    => $status,
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A New Department Data
    *
    * @param string
    * @return int
    */
   public function createDepartment($category, $title, $status)
   {
      $sql_code = "INSERT INTO `departments` (
            `category_id`, `title`, `status`, `created_at`
         ) 
         VALUES (
            :CATEGORY_ID, :D_TITLE, :D_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':CATEGORY_ID' => $category,
         ':D_TITLE'     => $this->encode($title),
         ':D_STATUS'    => $status,
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create A New Service Data
    *
    * @param string
    * @return int
    */
   public function createService($category, $title, $status)
   {
      $sql_code = "INSERT INTO `services` (
            `category_id`, `title`, `status`, `created_at`
         ) 
         VALUES (
            :CATEGORY_ID, :S_TITLE, :S_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':CATEGORY_ID' => $category,
         ':S_TITLE'     => $this->encode($title),
         ':S_STATUS'    => $status,
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create New Products Data
    *
    * @param string
    * @return int
    */
   public function createProduct($service, $unique_id, $title, $details, $price, $status)
   {
      $sql_code = "INSERT INTO `products` (
            `service_id`, `unique_id`, `title`, `details`, `price`, `status`, `created_at`
         ) 
         VALUES (
            :S_ID, :U_ID, :P_TITLE, :P_DETAILS, :P_PRICE, :P_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':S_ID'        => $service,
         ':U_ID'        => $unique_id,
         ':P_TITLE'     => $this->encode($title),
         ':P_DETAILS'   => $this->encode($details),
         ':P_PRICE'     => $price,
         ':P_STATUS'    => $status,
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create New Doctor Data
    *
    * @param string
    * @return int
    */
   public function addDoctor($dept_id, $name, $email, $mobile, $gender, $nid, $avatar, $specialty, $degree, 
      $designation, $organization, $address, $chember, $location, $schedule, $start, $end, $status)
   {
      $sql_code = "INSERT INTO `doctors` (
            `department_id`, `full_name`, `email`, `mobile`, `gender`, `nid_card_no`, `avatar`,  
            `specialty`, `degree`, `designation`, `organization`, `address`, `chember`, `location`, 
            `schedule`, `start_time`, `end_time`, `status`, `created_at`
         ) 
         VALUES (
            :DEPT_ID, :D_NAME, :D_EMAIL, :D_MOBILE, :D_GENGER, :D_NID_NO, :D_AVATAR, :D_PATH, 
            :D_SPECIALTY, :D_DEGREE, :D_DESIGNATION, :D_ORGANIZATION, :D_ADDRESS, :D_CHEMBER, :D_LOCATION, 
            :D_SCHEDULE, :D_START_TIME, :D_END_TIME, :D_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':DEPT_ID'        => $dept_id,
         ':D_NAME'         => $this->encode($name),
         ':D_EMAIL'        => $this->encode(filter_var($email, FILTER_VALIDATE_EMAIL)),
         ':D_MOBILE'       => $this->encode($mobile),
         ':D_GENGER'       => $gender,
         ':D_NID_NO'       => $this->encode($nid),
         ':D_AVATAR'       => $avatar,
         ':D_SPECIALTY'    => $specialty,
         ':D_DEGREE'       => $this->encode($degree),
         ':D_DESIGNATION'  => $this->encode($designation),
         ':D_ORGANIZATION' => $this->encode($organization),
         ':D_ADDRESS'      => $this->encode($address),
         ':D_CHEMBER'      => $this->encode($chember),
         ':D_LOCATION'     => $this->encode($location),
         ':D_SCHEDULE'     => $this->encode($schedule),
         ':D_START_TIME'   => $start,
         ':D_END_TIME'     => $end,
         ':D_STATUS'       => $status,
         ':CREATED_AT'     => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create New Appointment Request Data
    *
    * @param string
    * @return int
    */
   public function appointmentRequest($date, $user, $doctor, $dateTime)
   {
      $sql_code = "INSERT INTO `appointment_request` (
            `date`, `user_id`, `doctor_id`, `scheduled_at`, `created_at`
         ) 
         VALUES (
            :DATES, :USERS_ID, :DOCTOR_ID, :SCHEDULED_AT, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':DATES'          => $date,
         ':USERS_ID'       => $user,
         ':DOCTOR_ID'      => $doctor,
         ':SCHEDULED_AT'   => $this->encode($dateTime),
         ':CREATED_AT'     => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $lastInsertId;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }


   
   /**
    * Create New Appointment Confirmed Data
    *
    * @param string
    * @return int
    */
   public function createAppointment($id, $name, $phone, $email, $dateTime, $doctor, $department, $date)
   {
      $sql_code = "INSERT INTO `appointments` (
            `user_id`, `user_name`, `user_phone`, `user_email`, `date_time`, `doctor_name`, `department`, `status`, `date`, `created_at`
         ) 
         VALUES (
            :USERS_ID, :USERS_NAME, :USERS_PHONE, :USERS_EMAIL, :DATE_TIME, :DOCTOR_NAME, :DEPARTMENT, :A_STATUS, :DATES, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':USERS_ID'    => $this->encode($id),
         ':USERS_NAME'  => $this->encode($name),
         ':USERS_PHONE' => $this->encode($phone),
         ':USERS_EMAIL' => $this->encode($email),
         ':DATE_TIME'   => $this->encode($dateTime),
         ':DOCTOR_NAME' => $this->encode($doctor),
         ':DEPARTMENT'  => $this->encode($department),
         ':A_STATUS'    => "Completed",
         ':DATES'       => $this->encode($date),
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $lastInsertId;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create New ShopCart Data
    *
    * @param string
    * @return int
    */
   public function addToCart($date, $user_id, $price_total)
   {
      $sql_code = "INSERT INTO `shopcarts` (
            `date`, `user_id`, `price_total`, `status`, `created_at`
         ) 
         VALUES (
            :CART_DATE, :USERS_ID, :PRICE_TOTAL, :CART_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':CART_DATE'   => $date,
         ':USERS_ID'    => $user_id,
         ':PRICE_TOTAL' => $price_total,
         ':CART_STATUS' => "Pending",
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $lastInsertId;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create New Order Items Data
    *
    * @param string
    * @return int
    */
   public function addOrderItems($orderId, $serviceId, $productId, $price)
   {
      $sql_code = "INSERT INTO `order_items` (
            `shopcart_id`, `service_title`, `product_id`, `product_price`, `created_at`
         ) 
         VALUES (
            :SHOPCART_ID, :SERVICE_ID, :PRODUCT_ID, :PRODUCT_PRICE, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':SHOPCART_ID'    => $orderId,
         ':SERVICE_ID'     => $serviceId,
         ':PRODUCT_ID'     => $productId,
         ':PRODUCT_PRICE'  => $price,
         ':CREATED_AT'     => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Create Inventory Data
    *
    * @param string
    * @return int
    */
   public function addInventory($date, $user, $name, $email, $mobile, $service, $product, $price)
   {
      $sql_code = "INSERT INTO `inventory` (
            `date`, `user_id`, `name`, `email`, `mobile`, `service`, `product`, `price`, `created_at`
         ) 
         VALUES (
            :C_DATE, :U_ID, :U_NAME, :U_EMAIL, :U_MOBILE, :S_TITLE, :P_TITLE, :P_PRICE, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':C_DATE'      => $date,
         ':U_ID'        => $user,
         ':U_NAME'      => $name,
         ':U_EMAIL'     => $email,
         ':U_MOBILE'    => $mobile,
         ':S_TITLE'     => $service,
         ':P_TITLE'     => $product,
         ':P_PRICE'     => $price,
         ':CREATED_AT'  => date("Y-m-d H:i:s")
      );

      try {
         if ($query->execute($values)) {
            $totalRowInserted = $query->rowCount();
            $lastInsertId = $this->connection->lastInsertId();

            return $totalRowInserted;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }
}
