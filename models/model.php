<?php

abstract class Model {
	private $dbh;

	protected function execReq($req, $array = null, $typeArray = null){
		if ($array == null) {
			$res = $this->get_db()->query($req);
		} else {
			$res = $this->get_db()->prepare($req);
			$res = bindArrayValue($res, $array, $typeArray);
			$res->execute();
		}
		return ($res);
	}

	private function bindArrayValue($req, $array, $typeArray = false)
	{
		if(is_object($req) && ($req instanceof PDOStatement))
		{
			foreach($array as $key => $value)
			{
				if($typeArray)
					$req->bindValue(":$key",$value,$typeArray[$key]);
				else
				{
					if(is_int($value))
						$param = PDO::PARAM_INT;
					elseif(is_bool($value))
						$param = PDO::PARAM_BOOL;
					elseif(is_null($value))
						$param = PDO::PARAM_NULL;
					elseif(is_string($value))
						$param = PDO::PARAM_STR;
					else
						$param = FALSE;
					if($param)
						$req->bindValue(":$key",$value,$param);
				}
			}
			return ($req);
		}
	}

	private function get_db() {
		if ($this->dbh == null) {
			require './config/database.php';
			$this->dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return ($this->dbh);
		}
	}
}

?>
