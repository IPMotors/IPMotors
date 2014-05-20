<?php

Class SelectMarketing
{
	public function __construct()
	{

	}

	public function setSelect($arrSelect,$name)
	{	
		$string = "<select name=$name></br>";
		foreach($arrSelect as $key => $value) {
			if(!is_numeric($value)) {
				$string.= "<option name=$key value=$key>$value</option></br>";
			}
		}	
		$string .= "</select></br>";
		return $string;
	}

	public function setSelectVehicules($arrSelect,$name)
	{

		$string = "<select name=$name></br>";
		foreach($arrSelect as $value) {
			$string.= "<option name={$value['id']} value={$value['id']}>{$value['marque']} - {$value['modele']}</option></br>";
		}
		$string .= "</select></br>";
		return $string;
	}

	public function setSelectAge($arrSelect,$name)
	{
		$string = "<select name=$name></br>";
		foreach($arrSelect as $key => $value) {
			$string.= "<option name=$key value=$key>$value</option></br>";
		}
		$string .= "</select></br>";
		return $string;
	}


}