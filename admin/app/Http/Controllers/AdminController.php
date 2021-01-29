<?php

class AdminController extends MiscellaneousController
{
   /**
    * Authenticate Login Access
    * BackEnd Application Only
    *
    * @param string
    * @return array
    */
   public function tryLogin($email, $password)
   {
      $sql_code = "SELECT * FROM `admins` 
                   WHERE `admin_email`    = :ADMIN_EMAIL 
                   AND `admin_password`   = :ADMIN_PASSWORD 
                   AND `admin_status`     = :ADMIN_STATUS";

      $query = $this->connection->prepare($sql_code);

      $values = array(
         ':ADMIN_EMAIL'    => $this->encode($email),
         ':ADMIN_PASSWORD' => $this->encode($password),
         ':ADMIN_STATUS'   => 'Active'
      );

      try {
         if ($query->execute($values)) {
            $dataList = $query->fetchAll(PDO::FETCH_ASSOC);
            $totalRowSelected = $query->rowCount();

            if ($totalRowSelected > 0) {
               return $dataList;
            } else {
               throw new Exception();
            }
         }
      } catch (Exception $e) {
         return false;
      }
   }



   /**
    * Authenticate Password Update
    *
    * @param string|int
    * @return null
    */
   public function updatePassword($password, $id)
   {
      $sql_code = "UPDATE `admins` 
                   SET `admin_password` = :ADMIN_PASSWORD, `updated_at` = :UPDATED_AT 
                   WHERE `id` = :ID";

      $query = $this->connection->prepare($sql_code);

      $values = array(
         ':ADMIN_PASSWORD' => $this->encode($password),
         ':UPDATED_AT'     => date('Y-m-d H:i:s'),
         ':ID'             => $id
      );

      try {
         if ($query->execute($values)) {
            $totalRowUpdated = $query->rowCount();
            return $totalRowUpdated;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }
   

   
   /**
    * Create a New Admin Data
    *
    * @param string|int
    * @return int
    */
   public function createAdmin($name, $email, $mobile, $nid, $gender, $role, $avatar, $password, $status)
   {
      $sql_code = "INSERT INTO `admins` (
            `admin_name`, `admin_email`, `admin_mobile`, `admin_nidcard_no`, `admin_gender`, `admin_role_type`, 
            `admin_avatar`, `admin_password`, `admin_status`, `created_at`
         )
         VALUES (
            :ADMIN_NAME, :ADMIN_EMAIL, :ADMIN_MOBILE, :ADMIN_NID_NO, :ADMIN_GENDER, :ADMIN_ROLE, 
            :ADMIN_AVATAR, :ADMIN_PASSWORD, :ADMIN_STATUS, :CREATED_AT
         )";

      $query = $this->connection->prepare($sql_code);

      $values = array(
         ':ADMIN_NAME'     => $this->encode($name),
         ':ADMIN_EMAIL'    => $this->encode(filter_var($email, FILTER_VALIDATE_EMAIL)),
         ':ADMIN_MOBILE'   => $this->encode($mobile),
         ':ADMIN_NID_NO'   => $this->encode($nid),
         ':ADMIN_GENDER'   => $gender,
         ':ADMIN_ROLE'     => $role,
         ':ADMIN_AVATAR'   => $avatar,
         ':ADMIN_PASSWORD' => $this->encode($password),
         ':ADMIN_STATUS'   => $status,
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
    * Authenticate User LogIn Access
    *
    * @return array
    * @param string
    */
   public function loginAccess($email, $password)
   {
      $sql_code = "SELECT * FROM `users` 
                   WHERE `email` = :U_EMAIL 
                   AND `password` = :U_PASSWORD 
                   AND `status` = :U_STATUS";
      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':U_EMAIL'     => $this->encode($email),
         ':U_PASSWORD'  => $this->encode($password),
         ':U_STATUS'    => "Active"
      );

      try {
         if ($query->execute($values)) {
            $dataList = $query->fetchAll(PDO::FETCH_ASSOC);
            $totalRowSelected = $query->rowCount();
            if ($totalRowSelected > 0) {
               return $dataList;
            } else {
               throw new Exception();
            }
         }
      } catch (Exception $e) {
         return false;
      }
   }
}
