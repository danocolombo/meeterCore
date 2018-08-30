<?php
include 'mtrAOS.php';

$aosConfig->loadConfigFromDB;
$aosConfig->showConfig();
// $aosConfig->getConfig("teaching");
// $aosConfig->checkBConfig("meal");
// $aosConfig->checkBConfig("chips");

// $aosConfig->showConfig();

// $aosConfig->printGreeter();

// echo "<br/>Adding a new value";
// $aosConfig->addConfig("boss", "false");
// $aosConfig->showConfig();

// echo "FROM DB...<br/>";
// $aosConfig->showConfig();
// // echo "<br\>now change to...<br/>";

// $aosConfig->addConfig("meal", "true");
// // $aosConfig->showConfig();
// $aosConfig->saveConfigToDB();

// PIDs...
//  1   Dano
//  29  Missy
//  34  Billy
//  57  Andy
// $PID = 1;
// $aosPeepConfig->loadDisplayAOS($PID);

// foreach($aosPeepConfig->displayAOS as $key => $value){
//     echo "$key: $value<br/>";
// }





echo "<br/>done";