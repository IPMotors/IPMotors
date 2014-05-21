<?php

/**
* Permet de modifier et afficher les données d'un client dans l'espace formulaire
**/

Class FormManager
{

	private $db;
	private $generate;
	private $idMarque;
	private $idType;
	private $idModele;
	private $idPointFort;

	public function __construct($db)
	{
		$this->db = $db;
		$this->generate = new GenerateId(); 
	}

	public function getAllMarques()
	{
		$arrMarques = array();

		$query = "SELECT * FROM marques";
		$result = $this->db->query($query);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $oneMarque) {
			foreach ($oneMarque as $key => $value) {
				if($key == "id") {
					$id = $value;
				}
				else {
					$arrMarques[$id] = $value;
				}
			}
		}
		return $arrMarques;
	}

	public function getAllModeles()
	{
		$arrModeles = array();

		$query = "SELECT DISTINCT modele FROM vehicules ORDER BY modele ASC";
		$result = $this->db->query($query);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $oneMarque) {
			foreach ($oneMarque as $key => $value) {
				/*if($key == "id") {
					$id = $value;
				}
				else {*/
					$arrModeles[] = $value;
				//}
			}
		}
		return $arrModeles;
	}

	public function getAllTypes()
	{
		$arrTypes = array();

		$query = "SELECT id, type FROM types";
		$result = $this->db->query($query);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $oneMarque) {
			foreach ($oneMarque as $key => $value) {
				if($key == "id") {
					$id = $value;
				}
				else {
					$arrTypes[$id] = $value;
				}
			}
		}
		return $arrTypes;
	}

	public function getAllPointFort()
	{
		$arrPointFort = array();

		$query = "SELECT id, designation FROM pointfort";
		$result = $this->db->query($query);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $oneMarque) {
			foreach ($oneMarque as $key => $value) {
				if($key == "id") {
					$id = $value;
				}
				else {
					$arrPointFort[$id] = $value;
				}
			}
		}
		return $arrPointFort;
	}

	public function insertMarque($marque)
	{
		$id = $this->generate->generate();

		$this->setIdMarque($id);

		$query = "INSERT INTO marques(id,marque) VALUES($id,'$marque')";
		var_dump($query);
		$result = $this->db->query($query);
	}

	public function insertType($type)
	{
		$id = $this->generate->generate();

		$this->setIdType($id);

		$query = "INSERT INTO types(id,type) VALUES($id,'$type')";
		//var_dump($query);
		$result = $this->db->query($query);
	}

	public function insertModele($modele)
	{
		$id = $this->generate->generate();
		$idType = $this->getIdType();
		$idMarque = $this->getIdMarque();

		$query = "INSERT INTO vehicules(id,idtype,idmarque,modele) VALUES($id,$idType,$idMarque,'$modele')";
		$result = $this->db->query($query);
		//var_dump($query);
		$this->setIdModele($id);
	}

	public function insertPointFort($pointfort)
	{
		$idVehicule = $this->getIdModele();

		$query = "INSERT INTO pointfort(designation) VALUES('$pointfort')";
		var_dump($query);
		$result = $this->db->query($query);

		$idPointFort = $this->selectIdPointFort($pointfort);

		$querySearch = "SELECT * FROM posseder WHERE idVehicule = $idVehicule AND idPointFort = $idPointFort";
		var_dump($querySearch);
		$resultSearch = $this->db->query($querySearch);
		$resultSearch = $resultSearch->fetch(PDO::FETCH_ASSOC);

		if($resultSearch) {
			$query = "UPDATE posseder SET idPointFort = $idPointFort WHERE idVehicule = $idVehicule,";
			$result = $this->db->query($query);
			//var_dump($query);
		}
		else {
			$query = "INSERT INTO posseder(idVehicule,idPointFort) VALUES($idVehicule,$idPointFort)";
			$result = $this->db->query($query);
			//var_dump($query);
		}
	}

	public function selectidPointFort($pointFort)
	{
		$query = "SELECT id FROM pointfort WHERE designation = '$pointFort' ";
		//var_dump($query);
		$result = $this->db->query($query);
		$result = $result->fetch(PDO::FETCH_ASSOC);
		//var_dump($result);
		return $result['id'];

	}

	public function setIdMarque($id) { $this->idMarque = $id; }
	public function setIdType($id) { $this->idType = $id; }
	public function setIdModele($id) { $this->idModele = $id; }
	public function setIdPointFort($id) { $this->idPointFort = $id; }
	public function getIdMarque() { return $this->idMarque; }
	public function getIdType() { return $this->idType; }
	public function getidModele() { return $this->idModele; }
	public function getIdPointFort() { return $this->idPointFort; }

}