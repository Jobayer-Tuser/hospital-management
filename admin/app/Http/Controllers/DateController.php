<?php

class DateController
{
	public function date($string) : string
	{
		$explode = getDate(strtotime($string));
		$result = $explode['month'] .' '. $explode['mday'] .', '. $explode['year'];
		return $result;
	}

	public function dateFull($string) : string
	{
		$explode = getDate(strtotime($string));
		$result = $explode['weekday'] .' '. $explode['mday'] .' '. $explode['month'] .', '. $explode['year'];
		return $result;
	}

	public function day($string) : string
	{
		$explode = getDate(strtotime($string));
		return $explode['weekday'];
	}

	public function month($string) : string
	{
		$explode = getDate(strtotime($string));
		return $explode['month'];
	}

	public function year($string) : string
	{
		$year = date('Y', strtotime($string));
		return $year;
	}

	public function time($string) : string
	{
		$result = date('H:i A', strtotime($string));
		return $result;
	}

	public function dateTime($string) : string
	{
		$result = date('D, j M Y, H:i:s A', strtotime($string));
		return $result;
	}

	public function monthFirst($string) : string
	{
		$result = date('Y-m-01', strtotime($string));
		return $result;
	}

	public function monthLast($string) : string
	{
		$result = date('Y-m-t', strtotime(date('Y-m-01', strtotime($string))));
		return $result;
	}

	public function dayMonth($string) : string
	{
		$result = date('M j', strtotime($string));
		return $result;
	}

	public function monthYear($string) : string
	{
		$explode = getDate(strtotime($string));
		$result = $explode['month'] . ' ' . $explode['year'];
		return $result;
	}

	public function sqlDate($string) : string
	{
		$result = date('Y-m-d', strtotime($string));
		return $result;
	}

	public function sqlTime($string) : string
	{
		$result = date('H:i a', strtotime($string));
		return $result;
	}

	public function sqlDateTime($string) : string
	{
		$result = date('Y-m-d H:i:s a', strtotime($string));
		return $result;
	}

	public function revertDate($string) : string
	{
		$result = date('m/d/Y h:i a', strtotime($string));
		return $result;
	}

	public function sqlMonthBetween($string) : string
	{
		$getDate = date('Y-m-01', strtotime($string));
		$result = '"' . $getDate . '" AND "' . date('Y-m-t', strtotime($getDate)) . '"';
		return $result;
	}

	public function sqlDateBetween($start, $end)
	{
		$result = '"' . date('Y-m-d', strtotime($start)) . '" AND "' . date('Y-m-d', strtotime($end)) . '"';
		return $result;
	}

	public function sqlYearBetween($year)
	{
		$result = '"' . $year . '01-01" AND "' . $year . '-12-31"';
		return $result;
	}

	public function dayArray() : array
	{
		$dateArray = null;
		for($i = 0; $i <= 6; $i++) {
			$dateArray .= date('D', strtotime('+' .$i. ' day')) . ",";
		}
		$dateArray = rtrim($dateArray, ",");
		$dateArray = explode(',', $dateArray);

		return $dateArray;
	}

	public function dayFullArray() : array
	{
		$dateArray = null;
		for($i = 0; $i <= 6; $i++) {
			$dateArray .= date("l",time() + 86400 * $i) . ",";
		}
		$dateArray = rtrim($dateArray, ",");
		$dateArray = explode(',', $dateArray);

		return $dateArray;
	}

	public function timeElapsed($datetime, $full = false) : string
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);

		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}
