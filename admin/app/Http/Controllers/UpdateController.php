<?php

class UpdateController extends MiscellaneousController
{
	/**
    * Update Current Status Data
    *
    * @param string
    * @return int
    */
	public function changeStatus($table, $columnName, $currentStatus, $id)
	{
		if ($currentStatus == "Active") {
			$sql_code = "UPDATE {$table} SET {$columnName} = 'Inactive', updated_at = :UPDATED_AT WHERE id = :ID";
		} else if ($currentStatus == "Inactive") {
			$sql_code = "UPDATE {$table} SET {$columnName} = 'Active', updated_at = :UPDATED_AT WHERE id = :ID";
		}

		$query = $this->connection->prepare($sql_code);
		$values = array(':UPDATED_AT'	=> date("Y-m-d H:i:s"), ':ID' => $id);
		$query->execute($values);
		$totalRowUpdated = $query->rowCount();

		return $totalRowUpdated;
	}



	/**
	 * Update Categories Data
	 * [1] Including Image File
	 * [2] Excluding Image File
	 *
    * @param string
    * @return int
    */
	public function updateCategoryInc($title, $logo, $path, $status, $id)
	{
		$sql_code = "UPDATE `categories` 
						SET 
							`title`			= :C_TITLE, 
							`logo`			= :C_LOGO, 
							`path`			= :C_PATH, 
							`status`			= :C_STATUS, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':C_TITLE'		=> $this->encode($title),
			':C_LOGO'		=> $logo,
			':C_PATH'		=> $this->encode($path),
			':C_STATUS'		=> $status,
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
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

	public function updateCategoryExc($title, $status, $id)
	{
		$sql_code = "UPDATE `categories` 
						SET 
							`title`			= :C_TITLE, 
							`status`			= :C_STATUS, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':C_TITLE'		=> $this->encode($title),
			':C_STATUS'		=> $status,
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
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
	 * Update Department Data
	 *
    * @param string
    * @return int
    */
	public function updateDepartment($category, $title, $status, $id)
	{
		$sql_code = "UPDATE `departments` 
						SET 
							`category_id`	= :C_ID, 
							`title`			= :D_TITLE, 
							`status`			= :D_STATUS, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':C_ID'			=> $category,
			':D_TITLE'		=> $this->encode($title),
			':D_STATUS'		=> $status,
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
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
	 * Update Service Data
	 *
    * @param string
    * @return int
	 */
	public function updateService($category, $title, $status, $id)
	{
		$sql_code = "UPDATE `services` 
						SET 
							`category_id`	= :C_ID, 
							`title`			= :S_TITLE, 
							`status`			= :S_STATUS, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':C_ID'			=> $category,
			':S_TITLE'		=> $this->encode($title),
			':S_STATUS'		=> $status,
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
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
	 * Update Product Data
	 *
    * @param string
    * @return int
	 */
	public function updateProduct($service, $name, $details, $price, $status, $id)
	{
		$sql_code = "UPDATE `products` 
						SET 
							`service_id`	= :S_ID, 
							`title`			= :P_TITLE, 
							`details`		= :P_DETAILS, 
							`price`			= :P_PRICE, 
							`status`			= :P_STATUS, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':S_ID'			=> $service,
			':P_TITLE'		=> $this->encode($name),
			':P_DETAILS'	=> $this->encode($details),
			':P_PRICE'		=> $this->encode($price),
			':P_STATUS'		=> $status,
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
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
	 * Update Doctor Data
	 *
    * @param string
    * @return int
	 */
	public function updateDoctorInc($department, $name, $email, $mobile, $gender, $nid, $avatar, $path, $specialty,
		$degree, $designation, $organization, $address, $chember, $location, $schedule, $start, $end, $status, $id)
	{
		$sql_code = "UPDATE `doctors` 
						SET 
							`department_id`= :DEPT_ID, 
							`full_name`		= :D_NAME, 
							`email`			= :D_EMAIL, 
							`mobile`			= :D_MOBILE, 
							`gender`			= :D_GENDER, 
							`nid_card_no`	= :D_NID_NO, 
							`avatar`			= :D_AVATAR, 
							`path`			= :D_PATH, 
							`specialty`		= :D_SPECIALTY, 
							`degree`			= :D_DEGREE, 
							`designation`	= :D_DESIGNATION, 
							`organization`	= :D_ORGANIZATION, 
							`address`		= :D_ADDRESS, 
							`chember`		= :D_CHEMBER, 
							`location`		= :D_LOCATION, 
							`schedule`		= :D_SCHEDULE, 
							`start_time`	= :D_START_TIME, 
							`end_time`		= :D_END_TIME, 
							`status`			= :D_STATUS,
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);
		$values = array(
			':DEPT_ID'			=> $department,
			':D_NAME'			=> $this->encode($name),
			':D_EMAIL'			=> $this->encode($email),
			':D_MOBILE'			=> $this->encode($mobile),
			':D_GENDER'			=> $gender,
			':D_NID_NO'			=> $this->encode($nid),
			':D_AVATAR'			=> $avatar,
			':D_PATH'			=> $this->encode($path),
			':D_SPECIALTY'		=> $specialty,
			':D_DEGREE'			=> $this->encode($degree),
			':D_DESIGNATION'	=> $this->encode($designation),
			':D_ORGANIZATION'	=> $this->encode($organization),
			':D_ADDRESS'		=> $this->encode($address),
			':D_CHEMBER'		=> $this->encode($chember),
			':D_LOCATION'		=> $this->encode($location),
			':D_SCHEDULE'		=> $schedule,
			':D_START_TIME'	=> $start,
			':D_END_TIME'		=> $end,
			':D_STATUS'			=> $status,
			':UPDATED_AT'		=> date("Y-m-d H:i:s"),
			':ID'					=> $id
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

	
	public function updateDoctorExc($department, $name, $email, $mobile, $gender, $nid, $specialty, $degree, 
		$designation, $organization, $address, $chember, $location, $schedule, $start, $end, $status, $id)
	{
		$sql_code = "UPDATE `doctors` 
						SET 
							`department_id`= :DEPT_ID, 
							`full_name`		= :D_NAME, 
							`email`			= :D_EMAIL, 
							`mobile`			= :D_MOBILE, 
							`gender`			= :D_GENDER, 
							`nid_card_no`	= :D_NID_NO, 
							`specialty`		= :D_SPECIALTY, 
							`degree`			= :D_DEGREE, 
							`designation`	= :D_DESIGNATION, 
							`organization`	= :D_ORGANIZATION, 
							`address`		= :D_ADDRESS, 
							`chember`		= :D_CHEMBER, 
							`location`		= :D_LOCATION, 
							`schedule`		= :D_SCHEDULE, 
							`start_time`	= :D_START_TIME, 
							`end_time`		= :D_END_TIME, 
							`status`			= :D_STATUS,
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);
		$values = array(
			':DEPT_ID'			=> $department,
			':D_NAME'			=> $this->encode($name),
			':D_EMAIL'			=> $this->encode($email),
			':D_MOBILE'			=> $this->encode($mobile),
			':D_GENDER'			=> $gender,
			':D_NID_NO'			=> $this->encode($nid),
			':D_SPECIALTY'		=> $specialty,
			':D_DEGREE'			=> $this->encode($degree),
			':D_DESIGNATION'	=> $this->encode($designation),
			':D_ORGANIZATION'	=> $this->encode($organization),
			':D_ADDRESS'		=> $this->encode($address),
			':D_CHEMBER'		=> $this->encode($chember),
			':D_LOCATION'		=> $this->encode($location),
			':D_SCHEDULE'		=> $schedule,
			':D_START_TIME'	=> $start,
			':D_END_TIME'		=> $end,
			':D_STATUS'			=> $status,
			':UPDATED_AT'		=> date("Y-m-d H:i:s"),
			':ID'					=> $id
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
    * Update Cart Data
    *
    * @param string
    * @return int
    */
	public function updateCart($price, $id, $date)
	{
		$sql_code = "UPDATE `shopcarts` 
						SET 
							`price_total`	= :PRICE_TOTAL,
							`updated_at` 	= :UPDATED_AT 
						WHERE 
							`id` 				= :ID
						AND
							`date`			= :CART_DATE";

		$query = $this->connection->prepare($sql_code);
		$values = array(
			':PRICE_TOTAL'	=> $price,
			':UPDATED_AT' 	=> date("Y-m-d H:i:s"),
			':ID' 			=> $id,
			':CART_DATE'	=> $date
		);

		$query->execute($values);
		$totalRowUpdated = $query->rowCount();

		return $totalRowUpdated;
	}



   /**
    * Update Order Items Data
    *
    * @param string
    * @return int
    */
	public function updateCartStatus($status, $id)
	{
		$sql_code = "UPDATE `shopcarts` 
						SET 
							`status`			= :CART_STATUS,
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id` 				= :ID";

		$query = $this->connection->prepare($sql_code);
		$values = array(
			':CART_STATUS'		=> $status,
			':UPDATED_AT' 		=> date("Y-m-d H:i:s"),
			':ID'					=> $id
		);

		$query->execute($values);
		$totalRowUpdated = $query->rowCount();

		return $totalRowUpdated;
	}



   /**
    * Update Comment Status
    *
    * @param string
    * @return int
    */
	public function updateCommentStatus($status, $id)
	{
		$sql_code = "UPDATE `comments` SET `status` = :UPDATE_STATUS, `updated_at` = :UPDATED_AT WHERE `id` = :ID";
		$query = $this->connection->prepare($sql_code);
		$values = array(
			':UPDATE_STATUS'	=> $status,
			':UPDATED_AT' 		=> date("Y-m-d H:i:s"),
			':ID'					=> $id
		);

		$query->execute($values);
		$totalRowUpdated = $query->rowCount();
		return $totalRowUpdated;
	}

	

	/**
    * Update Account Data
    *
    * @param string
    * @return int
    */
	public function updateAccount($title, $status, $id)
	{
		$sql_code = "UPDATE `accounts` SET `title` = :A_TITLE, `status` = :A_STATUS, `updated_at` = :UPDATED_AT WHERE `id` = :ID";
		$query = $this->connection->prepare($sql_code);
		$values = array(
			':A_TITLE'		=> $this->encode($title),
			':A_STATUS'		=> $status,
			':UPDATED_AT' 	=> date("Y-m-d H:i:s"),
			':ID' 			=> $id
		);

		$query->execute($values);
		$totalRowUpdated = $query->rowCount();

		return $totalRowUpdated;
	}



	/**
    * Update User Data
    *
    * @param string
    * @return int
    */
	public function updateUserInc($avatar, $id)
	{
		$sql_code = "UPDATE `users` 
						SET 
							`avatar`			= :U_AVATAR, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`				= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':U_AVATAR'		=> $avatar,
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
		);

		try {
			if($query->execute($values)) {
				$totalRowUpdated = $query->rowCount();
				return $totalRowUpdated;
			} else {
				throw new Exception();
			}
		} catch(Exception $e) {
			return false;
		}
	}

	public function updateUserExc($name, $mobile, $email, $id)
	{
		$sql_code = "UPDATE `users` 
						SET 
							`full_name`		= :U_NAME, 
							`mobile`			= :U_MOBILE, 
							`email`			= :U_EMAIL, 
							`updated_at`	= :UPDATED_AT 
						WHERE 
							`id`					= :ID";

		$query = $this->connection->prepare($sql_code);

		$values = array(
			':U_NAME'		=> $this->encode($name),
			':U_MOBILE'		=> $this->encode($mobile),
			':U_EMAIL'		=> $this->encode(filter_var($email, FILTER_VALIDATE_EMAIL)),
			':UPDATED_AT'	=> date("Y-m-d H:i:s"),
			':ID'				=> $id
		);

		try {
			if($query->execute($values)) {
				$totalRowUpdated = $query->rowCount();
				return $totalRowUpdated;
			} else {
				throw new Exception();
			}
		} catch(Exception $e) {
			return false;
		}
	}
}
