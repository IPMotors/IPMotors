<?php

require_once('config.php');
require_once('classes/marketingManager.php');
require_once('classes/select.php');
require_once('classes/exportMail.php');
require_once('classes/csvWriter.php');
require_once('classes/sqlManager.php');
require_once('classes/formManager.php');
require_once('classes/generateId.php');
require_once('classes/mailManager.php');



$dns = 'mysql:host='.HOST.';dbname='.DBNAME.'';
  		$utilisateur = USER;
  		$motDePasse = PASS;
		$db = new PDO($dns, $utilisateur, $motDePasse);