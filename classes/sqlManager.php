<?php

Class SqlManager
{
	private $db;
	private $request = "";

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function select($arrData = array())
	{
		if(empty($arrData)) {
			$this->request = "SELECT * ";
		}
		else {
			$keys = array_keys($arrData);
			$lastKey = end($keys);
			$this->request = "SELECT ";
			foreach ($arrData as $key => $value) {
				if($key == $lastKey) {
					$this->request.= "$value as '$key' ";
				}
				else {
					$this->request.= "$value as '$key', ";
				}	
			}	
		}
		
		return $this->request;
	}

	public function delete()
	{

	}

	public function update()
	{

	}

	public function join()  
	{

	}

	public function from($tableName)
	{
		$this->request.= "FROM $tableName ";
		return $this->request;
	}

	public function where()
	{

	}

	public function union()
	{

	}

	public function groupBy($arrData)
	{

	}

	public function orderBy($arrData)
	{
		$stringData = implode(',',$arrData);
		$this->request.= "ORDER BY $stringData ";
		return $this->request;
	}

	public function limit($min = 1, $max = 30)
	{
		$this->request.= "LIMIT $min, $max ";
		return $this->request;
	}

	public function __toString()
	{
		return $this->request;
	}

}