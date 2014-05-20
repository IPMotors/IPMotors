<?php 
require_once('init.php');

$arrAge = array();
for($i = 0; $i <= 70; $i++) {
	$arrAge[$i] = $i;
}

$marketing = new MarketingManager();
$marketing->setAllChoix();
$marketing->setAllVehicules();
$marketing->setAllVilles();
$select = new SelectMarketing();
$choixActuel1 = $select->setSelect($marketing->getChoixActuel(),'choixA1');
$choixActuel2 = $select->setSelect($marketing->getChoixActuel(),'choixA2');
$choixActuel3 = $select->setSelect($marketing->getChoixActuel(),'choixA3');
$choixFutur1 = $select->setSelect($marketing->getChoixFutur(),'choixF1');
$choixFutur2 = $select->setSelect($marketing->getChoixFutur(),'choixF2');
$choixFutur3 = $select->setSelect($marketing->getChoixFutur(),'choixF3');
$choixVehicules = $select->setSelectVehicules($marketing->getChoixVehicules(),'vehicules');
$villes = $select->setSelect($marketing->getChoixVilles(),'villes');
$age = $select->setSelectAge($arrAge,'age');

// EXPORT MAILS
if(isset($_POST['exportation']) && !empty($_POST['exportation'])) {
	$export = new ExportMails($_POST);
	$e = $export->createRequestWithFilters($export->getFilters());
	$export->exportMails($e);
}
else {
?>

<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" type="text/css" href="css/style.css">
<head>
	<meta charset="UTF-8">
	<title>Espace Marketing</title>
</head>

<body>


	<h1>Espace Marketing</h1>

	<form method="POST">

		<div>	
			<p>Filtre véhicule actuel</p>
			<?php 
				echo $choixActuel1;
			 	echo $choixActuel2;
			 	echo $choixActuel3;
			?>
		</div>
		<div>
			<p>Filtre futur véhicule</p>
			<?php 
				echo $choixFutur1;
				echo $choixFutur2;
				echo $choixFutur3;
			?>
		</div>
		<div>
			<p>Filtre informations personnelles</p>
			<?php 
				echo $age;
				echo $villes;
			 	echo $choixVehicules;
			?>

		</div>

		<input type="submit" name="exportation" value="Exporter les mails">
		
	</form>
</body>
</html>
<?php } ?>