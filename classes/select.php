<?php

Class SelectMarketing
{
	public function __construct()
	{

	}

	public function setSelect($arrSelect)
	{

		$string = "<select></br>";
		foreach($arrSelect as $value) {
			$string.= "<option value={$value['id']}>{$value['designation']}</option></br>";
		}
		$string .= "</select></br>";
		return $string;
	}

	public function setSelectVehicules($arrSelect)
	{

		$string = "<select></br>";
		foreach($arrSelect as $value) {
			$string.= "<option value={$value['id']}>{$value['marque']} - {$value['modele']}</option></br>";
		}
		$string .= "</select></br>";
		return $string;
	}
}