<?php
include 'mtrAOS.php';



// $aosConfig->getConfig("greeter");
// $aosConfig->getConfig("teaching");
// $aosConfig->checkBConfig("meal");
// $aosConfig->checkBConfig("chips");

// $aosConfig->showConfig();

// $aosConfig->printGreeter();

// echo "<br/>Adding a new value";
// $aosConfig->addConfig("boss", "false");
// $aosConfig->showConfig();

$aosConfig->loadConfigFromDB();
echo "FROM DB...<br/>";
$aosConfig->showConfig();
// echo "<br\>now change to...<br/>";

$aosConfig->addConfig("meal", "true");
// $aosConfig->showConfig();
$aosConfig->saveConfigToDB();



echo "<br/>done";