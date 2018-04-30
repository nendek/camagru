<?php



abstract class Model {
	private $dbh;

	protected function execReq(){

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










abstract class Modele {

	// Objet PDO d'accès à la BD
	private $bdd;

	// Exécute une requête SQL éventuellement paramétrée
	protected function executerRequete($sql, $params = null) {
		if ($params == null) {
			$resultat = $this->getBdd()->query($sql);    // exécution directe
		}
		else {
			$resultat = $this->getBdd()->prepare($sql);  // requête préparée
			$resultat->execute($params);
		}
		return $resultat;
	}

	// Renvoie un objet de connexion à la BD en initialisant la connexion au besoin
	private function getBdd() {
		if ($this->bdd == null) {
			// Création de la connexion
			$this->bdd = new PDO('mysql:host=localhost;dbname=monblog;charset=utf8',
				'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		return $this->bdd;
	}

}




?>
