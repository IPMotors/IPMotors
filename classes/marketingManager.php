<?php

Class MarketingManager
{
	/**
	* Classe permettant d'exporter les mails utilisateurs en fonction de certains critères
	**/

	private $age;
	private $ville;
	private $vehiculePossede;
	private $arrChoixFutur = array();
	private $arrChoixActuel = array();
	private $arrChoixVehicules = array();
	private $arrChoixVilles = array();

	public function __construct()
	{
		$dns = 'mysql:host='.HOST.';dbname='.DBNAME.'';
  		$utilisateur = USER;
  		$motDePasse = PASS;
		$this->db = new PDO($dns, $utilisateur, $motDePasse);
	}

	public function setAge($age) { $this->age = (int) $age; }
	public function setVille($ville) { $this->ville = (string) $ville; }
	public function setvehiculePossede($vehiculeP) { $this->vehiculePossede = $vehiculeP; }
	public function setChoixFutur($arrChoix) { $this->arrChoixFutur = $arrChoix; }
	public function setChoixActuel($arrChoix) { $this->arrChoixActuel = $arrChoix; }
	public function setChoixVehicules($arrChoix) { $this->arrChoixVehicules = $arrChoix; }
	public function setChoixVilles($arrChoix) { $this->arrChoixVilles = $arrChoix; }


	public function getAge() { return $this->age; }
	public function getVille() { return $this->ville; }
	public function getVehiculePossede() { return $this->vehiculePossede; }
	public function getChoixActuel() { return $this->arrChoixActuel; }
	public function getChoixFutur() { return $this->arrChoixFutur; }
	public function getChoixVehicules() { return $this->arrChoixVehicules; }
	public function getChoixVilles() { return $this->arrChoixVilles; }


	public function setAllChoix()
	{
		$arrResult = array();

		$sth = $this->db->prepare("SELECT * FROM pointfort");
		$sth->execute();

		$result = $sth->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $arrData) {
			foreach ($arrData as $key => $value) {
				if($key == "id") {
					$id = $value;
				}
				else {
					$arrResult[$id] = $value;
				}
			}
		}

		$this->setChoixFutur($arrResult);
		$this->setChoixActuel($arrResult);
	}

		public function setAllVehicules()
	{
		$arrResult = array();

		$sth = "SELECT vehicules.id, modele, marque FROM vehicules INNER JOIN marques ON marques.id = vehicules.idmarque  ORDER BY marque, modele";
		$sth = $this->db->query($sth);

		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($result as $key => $value) {
			$arrResult[$key] = $value;
		}

		$this->setChoixVehicules($arrResult);
	}

	public function setAllVilles()
	{
		$arrResult = array();

		$sth = "SELECT ville FROM clients ORDER BY ville";
		$sth = $this->db->query($sth);

		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($result as $key => $value) {
			$arrResult[$key] = $value['ville'];
		}

		$this->setChoixVilles($arrResult);
	}


	/**
	* Parse les données du tableau pour que les valeurs puissent être insérées dans une requête sql
	* @return string $string
	**/
	public function parseChoix($arrChoix)
	{
		$string = "";
		foreach ($arrChoix as $key => $oneChoix) {
			if($key == 0) {
				$string.= "'$oneChoix'";
			}
			else {
				$string.= ",'$oneChoix'";
			}
		}
		return $string;
	}
}