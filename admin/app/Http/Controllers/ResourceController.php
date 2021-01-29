<?php

class ResourceController
{
	/**
	 * ------------------------------------------
	 * Root Source Path of ScaffFolding Directory
	 * ------------------------------------------
	 * 
	 * @param string|null|bool
	 * @return string
	 */
	public function asset($fileName, $plugin = null, $version = false): string
	{
		//Directory Configuration
		if (!is_null($plugin)) {
			$directory = 'public/assets/' . $plugin . '/';
		} else {
			$directory = 'public/assets/';
		}

		//CSS or JavaScript Directory
		$getFileExtention = explode('/', $fileName);
		if (is_array($getFileExtention) && count($getFileExtention) == 1) {
			if (strpos($fileName, 'css')) {
				$directory = $directory . 'css/';
			} elseif (strpos($fileName, 'js')) {
				$directory = $directory . 'js/';
			} elseif (count($getFileExtention) > 1) {
				$directory = $directory;
			}
		}

		//Images Directory
		$imageType = ['jpg', 'jpeg', 'png', 'ico', 'svg'];
		$getImageExtention = explode('.', $fileName);
		if (in_array(end($getImageExtention), $imageType)) {
			$directory = $directory . 'images/';
		}

		//Version Changing
		if (is_bool($version) && $version === false) {
			$directory = $directory . $fileName;
		} else {
			$directory = $directory . $fileName . '?' . rand(0, 9) . '.' . rand(0, 9);
		}

		return $directory;
	}



	/**
	 * ------------------------------------------
	 * Dynamic Page Title
	 * ------------------------------------------
	 * 
	 * @param string|null
	 * @return string
	 */
	public function pagetTitle($appName = null, $type = null): string
	{
		$pageName = basename($_SERVER['PHP_SELF']);
		$dash = strpos($pageName, '-');

		if (!is_null($type)) {
			$type = ' ' . $type . ' ';
		} else {
			$type = ' | ';
		}

		//Excluding Application Title
		if (is_null($appName)) {
			if ($dash > 0) {
				$title = ucwords(str_replace('.php', '', str_replace('-', ' ', $pageName)));
			} else {
				$title = ucwords(str_replace('.php', '', $pageName));
			}
		}

		//Including Application Title
		if (!is_null($appName)) {
			if ($dash > 0) {
				$title = ucwords($appName . $type . str_replace('.php', '', str_replace('-', ' ', $pageName)));
			} else {
				$title = ucwords($appName . $type .  str_replace('.php', '', $pageName));
			}

			if ($pageName == "index.php") {
				$title = ucwords($appName . $type .  str_replace('.php', '', 'home'));
			}
		}

		return $title;
	}



	/**
	 * ------------------------------------------
	 * Dynamic BreadCrumb
	 * ------------------------------------------
	 * 
	 * @param void
	 * @return string
	 */
	public function breadCrumb()
	{
		$title = $this->pagetTitle();

		//BreadCrumb Template
		function template($value = null)
		{
			if (!is_null($value)) {
				$template = '
					<li class="breadcrumb-item active">
						<a href="javascript:void(0);">' . $value . '</a>
					</li>
				';
				return $template;
			}
		}

		//Define Each Navigation Array
		$general = ['Dashboard'];
		$admin = ['Add Admin', 'Admins'];
		$doctor = ['Add Doctor', 'Doctors', 'Edit Doctor'];
		$user = ['Users', 'User Profile', 'Comments', 'Blank Page'];
		$application = ['Categories', 'Departments', 'Services', 'Service Details', 'Products', 'Edit Products'];
		$account = ['Add Statement', 'Expenditure', 'Income', 'Monthly'];
		$order = ['Add Orders', 'Orders'];
		$appointment = ['Make Appointment', 'Appointments'];

		if (in_array($title, $general)) {
			$breadCrumb = template();
		}
		if (in_array($title, $admin)) {
			$breadCrumb = template('Manage Admin');
		}
		if (in_array($title, $doctor)) {
			$breadCrumb = template('Manage Doctor');
		}
		if (in_array($title, $user)) {
			$breadCrumb = template('Manage User');
		}
		if (in_array($title, $application)) {
			$breadCrumb = template('Manage Application');
		}
		if (in_array($title, $account)) {
			$breadCrumb = template('Manage Accounts');
		}
		if (in_array($title, $order)) {
			$breadCrumb = template('Manage Orders');
		}
		if (in_array($title, $appointment)) {
			$breadCrumb = template('Manage Appointment');
		}

		return $breadCrumb;
	}
}
