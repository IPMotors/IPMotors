<?php

Class ExportMails
{
	private $filters = array();
	private $logCsv = array();

	public function __construct($data)
	{
		$dns = 'mysql:host='.HOST.';dbname='.DBNAME.'';
  		$utilisateur = USER;
  		$motDePasse = PASS;
		$this->db = new PDO($dns, $utilisateur, $motDePasse);
		$this->setFilters($data);
	}

	public function setFilters($data)
	{
		foreach ($data as $key => $value) {
			$this->filters[$key] = $value;
		}
	}

	public function getFilters() { return $this->filters; }

	public function createRequestWithFilters($filters)
	{

		$query = "SELECT DISTINCT mail FROM clients INNER JOIN vehicules ON clients.idVehicule = vehicules.id ";
		$query.= "INNER JOIN posseder ON posseder.idVehicule = vehicules.id INNER JOIN pointfort ON posseder.idPointFort = pointfort.id ";
		$query.= "WHERE ";

		$possederA = " ((posseder.idPointFort IN(";
		$possederF = " OR (posseder.idPointFort IN(";
		foreach ($filters as $key => $value) {
			if(preg_match('/^choixA/',$key)) {
				$possederA.= "'$value',";
			}
			if(preg_match('/^choixF/',$key)) {
				$possederF.= "'$value',";
			}
			if($key == "vehicules") {
				$vehicule = "AND vehicules.id = $value ";
			}
			if($key == "age") {
				$annee = $this->getYear($value);
				$age = "AND YEAR(dateNaissance) = '$annee'";
			}
		}
		$possederA.= "'') AND posseder.futur = 0) ";
		$possederF.= "'') AND posseder.futur = 1)) ";

		$query.= $possederA.$possederF.$vehicule.$age;
		//var_dump($query);
		$query = $this->db->prepare($query);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;

	}

	public function getYear($age)
	{
		$annee = date('Y') - $age;
		//var_dump(date('Y'),$age);
		return $annee;
	}

	public function exportMails($arrMails)
	{
		$csvWriter = new CsvWriter();
		$output = "output/mails.csv";
		$csvWriter->open($output);
		$csvWriter->insertHeaderAutomatically();
		foreach ($arrMails as $oneMail) {
			foreach ($oneMail as $key => $value) {
				//$this->logCsv[$key] = $value;
				$csvWriter->writeLine($value);
			}
		}
		//$csvWriter->writeLineFromArray($this->logCsv);
		//var_dump($this->logCsv);
		$csvWriter->close();
		header('Content-type: text/csv');
		header('Content-Disposition: attachment;filename='.$output.'');
		// Le source du PDF original.pdf
		readfile(''.$output.'');

	}
}