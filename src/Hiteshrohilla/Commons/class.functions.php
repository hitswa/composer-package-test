<?php
namespace Hiteshrohilla\Commons;

require_once 'class.database.php';

class MySql {

	public static function checkRowExists($sql) {
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query or no result'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$rows   = $result->num_rows;
		$error = mysqli_error($mysqli);

		if($error == NULL) {
			if ($rows>0) {
				$res = array(
					'success'	=>	'1',
					'data'		=>	NULL,
					'error'		=>	NULL,
					'message'	=>	'row exists'
					);
			} else {
				$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	NULL,
					'message'	=>	'no row exists'
					);
			}
		} else {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$error,
					'message'	=>	'execution error'
					);
		}

		// $mysqli->close();
		return $res;
		exit();
	}

	public static function countRows($sql) {
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query or no result'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$rows   = $result->num_rows;
		$error = mysqli_error($mysqli);

		if($error == NULL) {
			if ($rows>0) {
				$res = array(
					'success'	=>	'1',
					'data'		=>	array('row_count' => $rows),
					'error'		=>	NULL,
					'message'	=>	'success'
					);
			} else {
				$res = array(
					'success'	=>	'0',
					'data'		=>	array('row_count' => 0),
					'error'		=>	NULL,
					'message'	=>	'no row exists'
					);
			}
		} else {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$error,
					'message'	=>	'execution error'
					);
		}
		// $mysqli->close();
		return $rows;
		exit();
	}

	public static function insertData($tablename,$dataArray) {

		$sql = "INSERT INTO `".$tablename."`(";
		foreach ($dataArray as $key=>$value){
			$sql .= "`" . $key . "`,";
		}
		$sql  = trim($sql,",");
		$sql .= ") VALUES (";
		foreach($dataArray as $key=>$value){
			$sql .= SecureInput($value) . ",";
		}
		$sql  = trim($sql,",");
		$sql .= ");";

		// return $sql;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query or no result'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$error = mysqli_error($mysqli);
		if($error == NULL) {

			$id = $mysqli->insert_id;

			if( $id != 0 ){

				$res = array(
						'success'	=>	'1',
						'data'		=>	array("id" => $id),
						'error'		=>	NULL,
						'message'	=>	'data inserted successfully'
						);
			} else {
				$res = array(
						'success'	=>	'0',
						'data'		=>	NULL,
						'error'		=>	$error,
						'message'	=>	'invalid query or no result'
						);
			}
		} else {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$error,
					'message'	=>	'execution error'
					);
		}
		// $mysqli->close();
		return $res;
		exit();
	}

	public static function updateData($tablename,$dataArray,$condition) {

		$sql = "UPDATE `".$tablename."` SET ";
		foreach($dataArray as $key=>$value) {
			$sql .= "`".$key."`=".SecureInput($value).",";
		}
		$sql  = trim($sql,",");
		$sql .= " WHERE ";
		foreach($condition as $key=>$value) {
			$sql .= "`".$key."`=".$value." AND ";
		}
		$sql  = substr($sql, 0, -4);
		
		$sql .= ";";

		// return $sql;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$error = mysqli_error($mysqli);

		if($error == NULL) {
			$res = array(
				'success'	=>	'1',
				'data'		=>	NULL,
				'error'		=>	NULL,
				'message'	=>	'data updated successfully'
				);
		} else {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$error,
					'message'	=>	'execution error'
					);
		}
		// $mysqli->close();
		return $res;
		exit();
	}

	public static function deleteData($tablename,$condition) {

		$sql = "DELETE FROM `".$tablename."` WHERE ";
		foreach($condition as $key=>$value) {
			$sql .= "`".$key."`=".$value." AND ";
		}
		$sql  = substr($sql, 0, -4);
		
		$sql .= ";";

		// return $sql;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$error = mysqli_error($mysqli);
		if($error == NULL) {
			if ($result === TRUE) {

				$res = array(
						'success'	=>	'1',
						'error'		=>	NULL,
						);
			} else {
				$res = array(
						'success'	=>	'0',
						'error'		=>	$error,
						);
			}
		} else {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$error,
					'message'	=>	'execution error'
					);
		}

		// $mysqli->close();
		return $res;
		exit();
	}

	public static function Execute($sql) {
		// return $sql;
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$error = mysqli_error($mysqli);
		if($error == NULL) {
			if ($result === TRUE) {

				$res = array(
						'success'	=>	'1',
						'data'		=>	NULL,
						'error'		=>	NULL,
						'message'	=>	'executed successfully'
						);
			} else {
				$res = array(
						'success'	=>	'0',
						'data'		=>	NULL,
						'error'		=>	NULL,
						'message'	=>	'execution fails'
						);
			}
		} else {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$error,
					'message'	=>	'execution error'
					);
		}
		// $mysqli->close();
		return $res;
		exit();
	}

	public static function fetchRow($sql) {
		// return $sql;
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query'
					);
			// $mysqli->close();
			return $res;
			exit();
		}
		$error = mysqli_error($mysqli);
		if($error == NULL) {
			if ($result === TRUE) {

				$numrow = $result->num_rows;

				if($numrow > 0){
					$rows = $result->fetch_assoc();
					$res = array(
							'success'	=>	'1',
							'data'		=> 	$rows,
							'error'		=>	NULL,
							'message'	=>	''
							);					
				} else {
					$res = array(
							'success'	=>	'0',
							'data'		=>	NULL,
							'error'		=>	NULL,
							'message'	=>	'no results found'
							);
				}

			} else {
				$res = array(
						'success'	=>	'0',
						'data'		=>	NULL,
						'error'		=>	NULL,
						'message'	=>	'no results found'
						);
			}
		} else {
			$res = array(
				'success'	=>	'0',
				'data'		=>	NULL,
				'error'		=>	$error,
				'message'	=>	'execution error'
				);
		}
		// $mysqli->close();
		return $res;
		exit();
	}

	public static function fetchAllRows($sql) {

		// return $sql;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$result = $mysqli->query($sql);
		if (!$result) {
			$res = array(
					'success'	=>	'0',
					'data'		=>	NULL,
					'error'		=>	$mysqli->error,
					'message'	=>	'invalid query'
					);
			return $res;
			exit();
		}
		$error = mysqli_error($mysqli);
		if($error == NULL) {
			if ($result === TRUE) {
				$numrow = $result->num_rows;
				if($numrow > 0){
					$res = array(
							'success'	=>	'1',
							'data'		=> 	$result,
							'error'		=>	NULL,
							);
					
				} else {
					$res = array(
							'success'	=>	'0',
							'data'		=> 	$result,
							'error'		=>	$error,
							);
				}				
			} else {
				$res = array(
						'success'	=>	'0',
						'data'		=>	NULL,
						'error'		=>	NULL,
						'message'	=>	'execution fails'
						);
			}
		} else {
			$res = array(
				'success'	=>	'0',
				'data'		=>	NULL,
				'error'		=>	$error,
				'message'	=>	'execution error'
				);
		}
		// $mysqli->close();
		return $res;
		exit();
	}

	public function SecureInput($value) {
		return mysqli_real_escape_string($this->_link, $value);
	}
	
}

?>