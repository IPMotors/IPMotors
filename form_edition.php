<?php

	require_once('init.php');
	$formManager = new FormManager($db);
	$select = new SelectMarketing();
	$readManager = new MailManager();

	$marques = $select->setSelect($formManager->getAllMarques(),'marque',true);
	$types = $select->setSelect($formManager->getAllTypes(),'type',true);
	$modeles = $select->setSelect($formManager->getAllModeles(),'modele',true);
	$pointFort1 = $select->setSelect($formManager->getAllPointFort(),'point_fort_s1',false);
	//$pointFort2 = $select->setSelect($formManager->getAllPointFort(),'point_fort_s2');
	//$pointFort3 = $select->setSelect($formManager->getAllPointFort(),'point_fort_s3');

	if(isset($_POST['actuel'])) {

		// Si champs texte type vide alors récupération de l'id du type sélectionné dans le select
		if(empty($_POST['type_text'])) {
			$formManager->setIdType($_POST['type']);
			var_dump($_POST['type']);
		}
		else {
			$formManager->insertType($_POST['type_text']);
		}
		// Si champs texte type vide alors récupération de l'id de la marque sélectionnée dans le select
		if(empty($_POST['marque_text'])) {
			$formManager->setIdMarque($_POST['marque']);
			var_dump($_POST['type']);
		}
		else {
			$formManager->insertMarque($_POST['marque_text']);
		}
		// Si champs texte type vide alors récupération de l'id du modele sélectionné dans le select
		if(empty($_POST['modele_text'])) {
			$formManager->setIdModele($_POST['modele']);
			var_dump($_POST['type']);
		}
		else {
			$formManager->insertModele($_POST['modele_text']);
		}

		// INSERTION DU POINT FORT 1
		if(!empty($_POST['point_fort_1'])) {
			var_dump($_POST['point_fort_1']);
			//exit;
			$formManager->setIdPointFort($_POST['point_fort_1']);
			$formManager->insertPointFort($_POST['point_fort_1']);
		}
		else if(!empty($_POST['point_fort_s1'])) {
			$formManager->setIdPointFort($_POST['point_fort_s1']);
			$formManager->insertPointFort(1,0);
		}
	}

	// MODIFICATION MAIL
	if(isset($_POST['modifier_mail'])) { ?>
		<div id="dialog-message" title="Mise à jour effectué">
			<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
			La mise à jour du contenu du mail a été faite avec succès</p>
		</div>
<?php
		$readManager->writeContentMail($_POST['content_mail']);

	}

?>
<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" type="text/css" href="css/style.css">
<head>
	<meta charset="UTF-8">
	<title>Edition</title>
	 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
 	<script>
	$(function() {
	$( "#tabs" ).tabs();
	});

 	$(function() {
		$( "#dialog-message" ).dialog({
			modal: true,
			buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
				}
			}
		});
	});
	</script>
</head>

<body>
<!--<div id="dialog-message" title="Download complete">
<p>
<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
Your files have downloaded successfully into the My Downloads folder.
</p>
<p>
Currently using <b>36% of your storage space</b>.
</p>
</div>-->
	<div id="titre_edition"><h1>Espace Formulaire</h1></div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Vehicule actuel</a></li>
			<li><a href="#tabs-2">Futur véhicule</a></li>
			<li><a href="#tabs-3">Mail notification</a></li>
		</ul>
		<div id="tabs-1">
			<form method="POST">
				<div id="champs1">
					<p>Modèle sujet de l'enquete : <?php echo $modeles ?></p>
					<p>Ajout d'un modèle : <input type="text" name="modele_text" /></p>
					<p>Type du modèle : <?php echo $types ?></p>
					<p>Ajout d'un type : <input type="text" name="type_text" /></p>
					<p>Marque du modèle : <?php echo $marques ?></p>
					<p>Ajout d'une marque : <input type="text" name="marque_text" /></p>
					<p>Points forts du modèle : <?php echo $pointFort1 ?></p>
					<p>Ajout d'un point fort : <input type="text" name="point_fort_1" /></p>
					<!--<p><input type="text" name="point_fort_2" /> ou <?php //echo $pointFort2 ?></p>
					<p><input type="text" name="point_fort_3" /> ou <?php //echo $pointFort3  ?></p>-->
					<p><input type="submit" name ="actuel" value="Ajouter un point fort" /></p>	
				</div>
			</form>
		</div>
		<div id="tabs-2">
			<form method="POST">
				<div id="champs2">
					<p>Modèle sujet de l'enquete : <?php echo $modeles ?></p>
					<p>Ajout d'un modèle : <input type="text" name="modele_text" /></p>
					<p>Type du modèle : <?php echo $types ?></p>
					<p>Ajout d'un type : <input type="text" name="type_text" /></p>
					<p>Marque du modèle : <?php echo $marques ?></p>
					<p>Ajout d'une marque : <input type="text" name="marque_text" /></p>
					<p>Points forts du modèle : <?php echo $pointFort1 ?></p>
					<p>Ajout d'un point fort : <input type="text" name="point_fort_1" /></p>
					<!--<p><input type="text" name="point_fort_2" /> ou <?php //echo $pointFort2 ?></p>
					<p><input type="text" name="point_fort_3" /> ou <?php //echo $pointFort3  ?></p>-->
					<p><input type="submit" name ="actuel" value="Ajouter un point fort" /></p>	
				</div>
			</form>
		</div>
		<div id="tabs-3">
			<form method="POST">
				<p><textarea rows="10" cols="70" name="content_mail"><?php echo $readManager->readContentMail() ?></textarea></p>
				<p><input type="submit" name ="modifier_mail" value="modifier"/>	
			</form>
		</div>
	</div>

</body>
</html>
<script type="text/javascript">
	
	function disabledInput(selectName, inputName)
	{
		var select = document.getElementsByName(selectName)[0];
		if(select.selectedIndex == 0) {
			document.getElementsByName(inputName)[0].disabled = false;
		}
		else {
			document.getElementsByName(inputName)[0].disabled = true;
		}

		var select = document.getElementsByName(selectName)[1];
		if(select.selectedIndex == 0) {
			document.getElementsByName(inputName)[1].disabled = false;
		}
		else {
			document.getElementsByName(inputName)[1].disabled = true;
		}
	}

</script>