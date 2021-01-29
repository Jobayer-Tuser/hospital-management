<?php

include('Controller.php');

class MiscellaneousController extends Controller
{
	/**
	 * Alert Notification
	 * 
	 * @param string|int
	 * @return component
	 */
	public function alertNotification($type, $position, $pexel = null, $message)
	{
		if (is_null($position)) {
			$position = 0;
		} else {
			$position = $position;
		}

		if($type == 'primary') {
			$indexed = '<i class="ion-alert-circled"></i> Oops!'; 
		} else {
			$indexed = '<i class="ion-checkmark"></i> Congratulation!'; 
		}

		if($position == 'top') {
			$position = 'top:' . (10 + $pexel) . '%;';
		} else {
			$position = 'bottom:' . (7 + $pexel) . '%;';
		}

		$alert = '
		<div style="position:absolute; ' . $position .'; right:50px; z-index:9999;" class="customAlert">
			<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>'.$indexed.'</strong> ' . ucwords($message) . '.
			</div>
		</div>
		';
		return $alert;
	}


	/**
	 * Page Path or URL
	 * 
	 * @return CurrentPageURL
	 * @param String
	 */
	public function getPath($url = null)
	{
		$explodeURL = explode('/', @$_SERVER['HTTP_REFERER']);
		$lastIndex = array_pop($explodeURL);
		$getUrlPath = implode('/', $explodeURL);
		$redirectTo = $getUrlPath . '/' . $url;

		return $redirectTo;
	}

	
	/**
	 * Get Unique Values for Multiple Array
	 * 
	 * @param array|string
	 * @return string
	 */
	public function arrayMergeUnique($array, $value, $unique = false)
	{
		$emptyArray = [];
		foreach ($array as $each) {
			$convertDate = strtotime($each[$value]);
			$getMonthYear = getDate($convertDate);
			$getMonthYear = $getMonthYear['month'] . ' ' . $getMonthYear['year'];
			array_push($emptyArray, $getMonthYear);
		}

		if(is_bool($unique) && $unique === false) {
			return $emptyArray;
		} else {
			return array_unique($emptyArray);
		}
	}
}
