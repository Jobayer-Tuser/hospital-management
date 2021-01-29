<?php

class ReadController extends MiscellaneousController
{
	/**
	 * Existing Data Checked Query Execute Based on A Specific Column Value
	 * Purpose: Pervent Duplicate Data Entry
	 * 
	 * @param string|int
	 * @return string
	 */
	public function isExist($table, $column, $value)
	{
		$sql_query = "SELECT * FROM `{$table}` WHERE `{$column}` = '{$value}'";
		$query = $this->connection->prepare($sql_query);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if (!empty($totalRowSelected)) {
			return $dataList[0][$column];
		} else {
			return 0;
		}
	}



	/**
	 * Existing Data Checked Query Execute Based on A Multiple Column Value
	 * Purpose: Pervent Duplicate Data Entry But Also Working with an ID 
	 * 
	 * @param string|int
	 * @return array
	 */
	public function isExistOnCondition($table, $column, $value, $basedOn = null, $id = null, $type = null, $typeValue = null)
	{
		if (!is_null($basedOn) && !is_null($type)) {
			$sql_query = "SELECT * FROM `{$table}` WHERE `{$column}` = '{$value}' AND `{$type}` = '{$typeValue}' AND `{$basedOn}` = '{$id}'";
		} elseif (!is_null($basedOn) && is_null($type)) {
			$sql_query = "SELECT * FROM `{$table}` WHERE `{$column}` = '{$value}' AND `{$basedOn}` = '{$id}'";
		} else {
			$sql_query = "SELECT * FROM `{$table}` WHERE `{$column}` = '{$value}'";
		}

		$query = $this->connection->prepare($sql_query);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if (!empty($totalRowSelected)) {
			return 1;
		} else {
			return 0;
		}
	}



	/**
	 * To Get Data Based On Null or Not Null Values
	 * 
	 * @param string|int
	 * @return array
	 */
	public function isNullOrNot($table, $column, $value = false, $id)
	{
		if ($value == true) {
			$sql_query = "SELECT * FROM `{$table}` WHERE `{$column}` IS NULL AND `id` = {$id}";
		} else {
			$sql_query = "SELECT * FROM `{$table}` WHERE `{$column}` IS NOT NULL AND `id` = {$id}";
		}

		$query = $this->connection->prepare($sql_query);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if (!empty($totalRowSelected)) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * Fetch All Data As Per Data Order
	 * Just Pass the Value as "true" only
	 * 
	 * @param null|bool
	 * @return array
	 */
	public function all($tableName, $orderBy = null)
	{
		if (!is_null($orderBy) && $orderBy === true) {
			$sql_code = "SELECT * FROM {$tableName} ORDER BY `id` DESC";
		} else {
			$sql_code = "SELECT * FROM {$tableName} ORDER BY `id` ASC";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * To Get Only a Single Column Data
	 * 
	 * @param string|int
	 * @return string
	 */
	public function column($table, $column, $id)
	{
		$sql_code = "SELECT {$column} FROM {$table} WHERE `id` = {$id}";
		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList[0][$column];
		} else {
			return 0;
		}
	}



	/**
	 * To Get Only a Single Column Data
	 * 
	 * @param string|int
	 * @return array
	 */
	public function columnArray($table, $column)
	{
		$sql_code = "SELECT {$column} FROM {$table}";
		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * To Get All Data Based on Specific Condition ("WHERE CLAUSE")
	 * 
	 * @param string|int
	 * @return array
	 */
	public function findOn($table, $column, $value, $column2 = null, $value2 = null)
	{
		if (is_null($column2) && is_null($value2)) {
			$sql_code = "SELECT * FROM {$table} WHERE {$column} = {$value}";
		} else {
			$sql_code = "SELECT * FROM {$table} WHERE {$column} = {$value} AND {$column2} = {$value2}";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * To Get All Data Based on Specific Condition ("WHERE CLAUSE with LIKE Operator")
	 * 
	 * @param string|int|float
	 * @return array
	 */
	public function findLike($table, $column, $value, $column2 = null, $value2 = null)
	{
		if (is_null($column2) && is_null($value2)) {
			$sql_code = "SELECT * FROM {$table} WHERE {$column} LIKE '%{$value}%'";
		} else {
			$sql_code = "SELECT * FROM {$table} WHERE {$column} LIKE '%{$value}%' AND {$column2} LIKE '%{$value2}%'";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * To Get All Data Based on Multiple Condition ("WHERE CLAUSE")
	 * 
	 * @param string|int
	 * @return array
	 */
	public function findColumnOn($table, $specificColumn, $column, $value, $column2 = null, $value2 = null)
	{
		if (is_null($column2) && is_null($value2)) {
			$sql_code = "SELECT {$specificColumn} FROM {$table} WHERE {$column} = {$value}";
		} else {
			$sql_code = "SELECT {$specificColumn} FROM {$table} WHERE {$column} = {$value} AND {$column2} = {$value2}";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * To Get Unique Data Only from a Table
	 * 
	 * @param string
	 * @return array
	 */
	public function uniqueOn($table, $column)
	{
		$sql_code = "SELECT DISTINCT {$column} FROM {$table}";
		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}



	/**
	 * To Get Calculation Value Total Based on Condition
	 * 
	 * @param string|int
	 * @return array
	 */
	public function sumTotalOn($table, $calculateColumn, $dateColumn, $dateValue, $typeColumn, $typeValue)
	{
		$sql_code = "SELECT SUM(`{$calculateColumn}`) AS 'total' FROM {$table}
						 WHERE `{$dateColumn}` = {$dateValue}
						 AND `{$typeColumn}` = {$typeValue}";

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}




	/**
	 * To Get Coutn Total Value Including Date Range
	 * 
	 * @param string|int|date_&_time
	 * @return array
	 */
	public function countTotal($table, $calculateColumn, $condition = null, $value = null, $dateRange = null, $rangeValue = null)
	{
		if (!is_null($condition) && is_null($dateRange)) {
			$sql_code = "SELECT COUNT(`{$calculateColumn}`) AS 'total' FROM {$table} 
							 WHERE `{$condition}` = {$value}";
		} elseif (!is_null($condition) && !is_null($dateRange)) {
			$sql_code = "SELECT COUNT(`{$calculateColumn}`) AS 'total' FROM {$table} 
							 WHERE `{$condition}` != {$value} 
							 AND `{$dateRange}` BETWEEN {$rangeValue}";
		} else {
			$sql_code = "SELECT COUNT(`{$calculateColumn}`) AS 'total' FROM {$table}";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}







	/* 
	* ****************************************************************
	* Revised Method
	* Data: 22 January 2021
	* **************************************************************** 
	*/

	/**
	 * To Get Calculation Value Total Based on Condition 
	 * Including Date Range ("REGEXP CLAUSE")
	 * 
	 * @return array
	 * @param string|int|datetime
	 */
	public function calculateTotal($table, $calculate, $col1 = null, $val1 = null, $date = null, $range = null)
	{
		$sql_code = "SELECT SUM(`{$calculate}`) AS 'total' FROM {$table}";
		if (!is_null($col1) && !is_null($date)) {
			$sql_code .= " WHERE `{$col1}` REGEXP {$val1} AND `{$date}` BETWEEN {$range}";
		} elseif (!is_null($col1) && is_null($date)) {
			$sql_code .= " WHERE `{$col1}` REGEXP {$val1}";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}


	/**
	 * To Get Each Month Total Calculation Value Including Date Range
	 * 
	 * @return array
	 * @param string|int|datetime
	 */
	public function eachMonthTotal($table, $calculate, $col1, $val1, $col2 = null, $val2 = null, $date = null, $range = null)
	{
		$sql_code = "SELECT SUM({$calculate}) AS 'total' FROM {$table} WHERE `{$col1}` = {$val1}";
		if (!is_null($col2) && !is_null($date)) {
			$sql_code .= " AND `{$col2}` = {$val2} AND `{$date}` BETWEEN {$range}";
		} elseif (!is_null($col2) && is_null($date)) {
			$sql_code .= " AND `{$col2}` = {$val2}";
		}

		$query = $this->connection->prepare($sql_code);
		$query->execute();
		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalRowSelected = $query->rowCount();

		if ($totalRowSelected > 0) {
			return $dataList;
		} else {
			return 0;
		}
	}
}
