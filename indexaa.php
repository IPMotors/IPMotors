<?php

require('init.php');


$sqlManager = new SqlManager($db);

$sqlManager->select($arrData);

echo $sqlManager;
