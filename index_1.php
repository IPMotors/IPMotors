<?php

require('init.php');

$marketing = new MarketingManager();
$marketing->setAllVehicules();
$select = new SelectMarketing();

echo $select->setSelectVehicules($marketing->getChoixVehicules());

