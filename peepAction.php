<?php
include 'mtgRedirects.php';
include 'database.php';
include 'peopleAOS.php';
// header("Expires: 0");
// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// header("Cache-Control: no-store, no-cache, must-revalidate");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");
/*
 * peepAction.php
 */

$Action = $_GET['Action'];
$PID = $_GET['PID'];


switch ($Action){
    case "Update":
        /*********************************
         * this is updating the ID
         * *****************************/
         
        updatePeepRecord($PID);
        exit;
        
    case "Add":
        /*********************************
         * add person to database
         * *******************************
         */
        addPerson();
        exit;
    
    case "AddPerson":
        /*************************************
         * add a new peep to database
         * ***********************************
         */
        addPerson();
        exit;
        
    case "RemoveTrainee":
        /*********************************
         * add person to training list
         * *******************************
         */
        $TID = $_GET["TID"];  // Training ID
        $PID = $_GET["PID"];  // People ID
        dropTraineeFromClass($TID, $PID);
        exit;
    case "DeletePeep":
        /*********************************
         * the request is to delete the 
         * user from the people table
         ********************************/
        $PID = $_GET["PID"];    // People ID
        $RUID = getRemovedUserID();
        //replaceUserInDB(PID, RUID);
        //dropPeepFromDatabase($PID);
        echo "Remvoed User ID:" + $RUID;
        exit;
    default:
        echo "not sure what to do with " . $Action;
        exit;
}
function getRemovedUserID(){
    //================================================
    // see if there is a "Removed User" in the users
    // table. If not create one. Return a id for
    // Removed User
    //================================================
    //data section start
    $FName = "Removed";
    $LName = "User";
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = $conn->prepare("SELECT `ID` FROM `people` WHERE `FName` = ? and `LName` = ?");
    $query->bind_param("ss", $FName, $LName);
    $query->execute();
    $query->bind_result($userid);
    $query->fetch();
    $query->close();
    
    if(empty($userid)) {
        // no Removed User, create it and return it. 
        $query = $connection->prepare("INSERT INTO `people` ( `FName`, `LName`, `Active`, `Notes`) VALUES ( ?, ?, ?, ?;");
        $query->bind_param("ssis", "Removed", "User", 1, "Used by the system, do not remove" );
        $query->execute();
        $query->close();
        //====------------------------------------------------
        // get the new number and return it
        //----------------------------------------------------
        $query = $connection->prepare("SELECT `ID` FROM `people` WHERE `FName` = ? and `LName` = ?");
        $query->bind_param("ss", "Removed", "User");
        $query->execute();
        $query->bind_result($userid);
        $query->fetch();
        $query->close();
    }
    return $userid;
    
}



function updatePeepRecord(){
    //======================================
    // updatePeepRecord update the ID passed
    // in and send back to people.php
    //======================================
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
    
    $PID = $_GET["PID"];
    $FName = $_POST["peepFName"];
    $LName = $_POST["peepLName"];
    $Phone1 = $_POST["peepPhone1"];
    $Phone2 = $_POST["peepPhone2"];
    $Email1 = $_POST["peepEmail1"];
    $Email2 = $_POST["peepEmail2"];
    $Address = $_POST["peepAddress"];
    $City = $_POST["peepCity"];
    $State = $_POST["peepState"];
    $Zipcode = $_POST["peepZipcode"];
    $SpiritualGifts = $_POST["peepSpiritualGifts"];
    $RecoveryArea = $_POST["peepRecoveryArea"];
    $RecoverySince = $_POST["peepRecoverySince"];
    $CRSince = $_POST["peepCRSince"];
    $Covenant = $_POST["peepCovenant"];
    $AreasServed = $_POST["peepAreasServed"];
    $JoyAreas = $_POST["peepJoyAreas"];
    $ReasonsToServe = $_POST["peepReasonsToServe"];
   /* -------------------------------------------------------------------
    * there will be checkboxes that are dynamically provided,
    * we will just get the data as we loop through to build update
    * sql command.
    ======================================*/
    
    $Notes = $_POST["peepNotes"];
    $Active = $_POST["peepActive"];

    $sql = "UPDATE people SET FName='" . mysql_real_escape_string($FName) . "',";
    $sql = $sql . " LName='" . mysql_real_escape_string($LName) .  "',";
    $sql = $sql . " Phone1='" . mysql_real_escape_string($Phone1) . "',";
    $sql = $sql . " Phone2='" . mysql_real_escape_string($Phone2) . "',";
    $sql = $sql . " Email1='" . mysql_real_escape_string($Email1) . "',";
    $sql = $sql . " Email2='" . mysql_real_escape_string($Email2) . "',";
    $sql = $sql . " Address='" . mysql_real_escape_string($Address) . "',";
    $sql = $sql . " City='" . mysql_real_escape_string($City) . "',";
    $sql = $sql . " State='" . mysql_real_escape_string($State) . "',";
    $sql = $sql . " Zipcode='" . mysql_real_escape_string($Zipcode) . "',";   
    if ($Active == "on"){
        $sql = $sql . " Active='1', Notes='";
    }else{
        $sql = $sql . " Active='0', Notes='";
    }
    $sql = $sql . $Notes . "' WHERE ID ='" . $PID . "'";
    /* --------------------------------------------------
     * going to run multiple queries because of possible
     * SQL length challenges
     * --------------------------------------------------
     */
    
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($con,$sql);
    mysqli_close($con);
    
    /* ---------------------------------------------------
     * now build another SQL statement
     * ---------------------------------------------------
     */
    $sql = "UPDATE people SET SpiritualGifts='" . mysql_real_escape_string($SpiritualGifts) . "',";
    $sql = $sql . " RecoveryArea='" . mysql_real_escape_string($RecoveryArea) .  "',";
    $sql = $sql . " RecoverySince='" . mysql_real_escape_string($RecoverySince) . "',";
    $sql = $sql . " CRSince='" . mysql_real_escape_string($CRSince) . "',";
    $sql = $sql . " Covenant='" . mysql_real_escape_string($Covenant) . "',";
    $sql = $sql . " AreasServed='" . mysql_real_escape_string($AreasServed) . "',";
    $sql = $sql . " JoyAreas='" . mysql_real_escape_string($JoyAreas) . "',";
    $sql = $sql . " ReasonsToServe='" . mysql_real_escape_string($ReasonsToServe) . "'";
    $sql = $sql . " WHERE ID ='" . $PID . "'";
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($con,$sql);
   
    
    /* ---------------------------------------------------
     * now build another SQL statement for AOS update
     * --------------------------------------------------*/
    // get system AOS and loop though getting checkbox values from form
    $aosPeepConfig = new mConfig();
    $aosPeepConfig->loadSystemConfigFromDB();
    $aosPeepConfig->loadConfigFromDB($PID);
    
    //we will build a string array of thall the checkbox settings and save to db
    $newConfig = "";
    $first = true;
    foreach($aosPeepConfig->systemAOS as $key => $value){
        //loop each configuration value, getting ONLY the values checked and save to newConfig
        
        $cbString = "cb" .  $key;
        if (empty($_POST[$cbString])){
        }else{
            //will save the setting, need to strip off the "cb" 
            $newConfig[substr($cbString, 2)] = "true";
//             $newConfig[$cbString] = "true";
        }
    }
//    echo "NOW: " . date("h:i:sa") . "<br/>";
//    echo "<br/>\$displayAOS <br/>--------------------------------------<br/>";
//    foreach ($aosPeepConfig->displayAOS as $key => $value){
//        echo "\$key: $key   \$value: $value<br/>";
//    }
//    echo "<br/>\$newConfig <br/>--------------------------------------<br/>";
//    foreach ($newConfig as $key => $value){
//        echo "\$key: $key   \$value: $value<br/>";
//    }
    // now we need to append any legacy settings from the people setting that are not included
//     echo "<br/>-----------------<br/>";
//     echo "stored user AOS values<br/>";
    
    foreach($aosPeepConfig->AOS as $key => $value){
//         echo "$key:$value<br/>";
        
        //loop through the systemAOS, and if the value is true, then use the form values, if it is false, add to newAOS.
        forEach($aosPeepConfig->systemAOS as $sysKey => $sysValue){
            if ($key == $sysKey){
                if($sysValue == "false"){
//                     echo "$key not on form. adding to list to preserve for future<br/>";
                    $newConfig[$key] = "true";
                }
            }
        }
        
        
//             if($aosPeepConfig->legacySettingInSystemAOS($key)){
//             echo "it is in system AOS, letting form settings update personal info<br/>";
//         }else{
//             echo "$key is not accounted for. adding to list to preserve for future<br/>";
//             $newConfig[$key] = "true";
//         }
        
        
        
//         if(array_key_exists($key, $newConfig)){
//             echo "key is accounted for in newConfig. Ignoring.<br/>";  
//         }else{
 
//             echo "$key is not in newAOS, would add to the AOS to save<br/>";
//             $newConfig[$key] = "true";
//         }
        
   }
//    echo "<br/>RESULTANT UPDATE THAT WOULD BE NEW USER AOS<br/>";
//    var_dump($newConfig);
//    $aosPeepConfig->showNewAndUser();
   
   
        //save the newConfig value to the people database
        //----------------------------------------------------------------
       $newValue = ""; 
       $first = true;
   foreach($newConfig AS $key=>$value){
       if ($first){
           $newValue = $key . ":" . $value;
           $first=false;
       }else{
           $newValue .= "|" . $key . ":" . $value;
       }
   }
    try {
        $stmt = $con->prepare("UPDATE people SET AOS = ? WHERE ID = ?");
        $stmt->bind_param("ss", $newValue, $PID);
        $stmt->execute();
        
        $stmt->close();
    } catch (PDOException $e) {
        echo "Error: [peepAction.php_updatePeepRecord()] " . $e->getMessage();
    }
    
    $con = null;
    
    
    
    
    
    
    
//     /* ------------------------------------
//      * now head out of here....
//      * ------------------------------------
//      */
    $tmp = "people.php";
    executeSQL($sql, $tmp);
    //testSQL($sql);
}

function addPerson(){
    //======================================
    // addPerson to DB from people.php
    //======================================
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
    $TID = $_GET["TID"];
    $PID = $_GET["PID"];
    $FName = $_POST["peepFName"];
    $LName = $_POST["peepLName"];
    $Phone1 = $_POST["peepPhone1"];
    $Phone2 = $_POST["peepPhone2"];
    $Email1 = $_POST["peepEmail1"];
    $Email2 = $_POST["peepEmail2"];
    $Address = $_POST["peepAddress"];
    $City = $_POST["peepCity"];
    $State = $_POST["peepState"];
    $Zipcode = $_POST["peepZipcode"];
    $SpiritualGifts = $_POST["peepSpiritualGifts"];
    $RecoveryArea = $_POST["peepRecoveryArea"];
    $RecoverySince = $_POST["peepRecoverySince"];
    $CRSince = $_POST["peepCRSince"];
    $Covenant = $_POST["peepCovenant"];
    $AreasServed = $_POST["peepAreasServed"];
    $JoyAreas = $_POST["peepJoyAreas"];
    $ReasonsToServe = $_POST['peepReasonsToServe'];
    $FellowshipTeam = $_POST["peepFellowshipTeam"];
    $TeachingTeam = $_POST["peepTeachingTeam"];
    $PrayerTeam = $_POST["peepPrayerTeam"];
    $NewcomersTeam = $_POST["peepNewcomersTeam"];
    $GreetingTeam = $_POST["peepGreetingTeam"];
    $SpecialEventsTeam = $_POST["peepSpecialEventsTeam"];
    $ResourceTeam = $_POST["peepResourceTeam"];
    $SmallGroupTeam = $_POST["peepSmallGroupTeam"];
    $StepStudyTeam = $_POST["peepStepStudyTeam"];
    $TransportationTeam = $_POST["peepTransportationTeam"];
    $WorshipTeam = $_POST["peepWorshipTeam"];
    $LandingTeam = $_POST["peepLandingTeam"];
    $CelebrationPlaceTeam = $_POST["peepCelebrationPlaceTeam"];
    $SolidRockTeam = $_POST["peepSolidRockTeam"];
    $MealTeam = $_POST["peepMealTeam"];
    $Chips = $_POST["peepChips"];
    $CRImen = $_POST["peepCRImen"];
    $CRIwomen = $_POST["peepCRIwomen"];
    $Notes = $_POST["peepNotes"];
    $Active = $_POST["peepActive"];

    $sql = "INSERT INTO people (FName, LName, Phone1, Phone2, Email1, Email2,";
    $sql = $sql . " Address, City, State, Zipcode,";
    $sql = $sql . " Active, Notes) VALUES (";
    $sql = $sql . "'" . mysql_real_escape_string($FName) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($LName) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($Phone1) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($Phone2) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($Email1) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($Email2) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($Address) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($City) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($State) . "',";
    $sql = $sql . "'" . mysql_real_escape_string($Zipcode) . "',";
    if ($Active == "on"){
        $sql = $sql . " '1', '";
    }else{
        $sql = $sql . " Active='0', Notes='";
    } 
    $sql = $sql . $Notes . "')";
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($con,$sql);
    //mysqli_close($con);
    
    //---------------------------------------------------
    // now have to get the ID from the insert above to
    // do the remainer of the updates. Don't query on name
    // or other data, because it could be duplicate, just
    // get the last entry in the people table.
    //---------------------------------------------------
    //data section start
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = $conn->prepare("SELECT `ID` FROM `people` ORDER BY ID DESC");
    $query->execute();
    $query->bind_result($newID);
    $query->fetch();
    $query->close();

    /* ---------------------------------------------------
     * now build another SQL statement
     * ---------------------------------------------------
     */
    $sql = "UPDATE people SET SpiritualGifts='" . mysql_real_escape_string($SpiritualGifts) . "',";
    $sql = $sql . " RecoveryArea='" . mysql_real_escape_string($RecoveryArea) .  "',";
    $sql = $sql . " RecoverySince='" . mysql_real_escape_string($RecoverySince) . "',";
    $sql = $sql . " CRSince='" . mysql_real_escape_string($CRSince) . "',";
    $sql = $sql . " Covenant='" . mysql_real_escape_string($Covenant) . "',";
    $sql = $sql . " AreasServed='" . mysql_real_escape_string($AreasServed) . "',";
    $sql = $sql . " JoyAreas='" . mysql_real_escape_string($JoyAreas) . "',";
    $sql = $sql . " ReasonsToServe='" . mysql_real_escape_string($ReasonsToServe) . "'";
    $sql = $sql . " WHERE ID ='" . $newID . "'";
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($con,$sql);
    mysqli_close($con);
    
    /* ---------------------------------------------------
     * now build another SQL statement
     * ---------------------------------------------------
     */
    $sql = "UPDATE people SET";
    if ($FellowshipTeam == "on"){
        $sql = $sql . " FellowshipTeam='1', ";
    }else{
        $sql = $sql . " FellowshipTeam='0', ";
    }
    if ($TeachingTeam == "on"){
        $sql = $sql . " TeachingTeam='1', ";
    }else{
        $sql = $sql . " TeachingTeam='0', ";
    }
    if ($PrayerTeam == "on"){
        $sql = $sql . " PrayerTeam='1', ";
    }else{
        $sql = $sql . " PrayerTeam='0', ";
    }
    if ($NewcomersTeam == "on"){
        $sql = $sql . " NewcomersTeam='1', ";
    }else{
        $sql = $sql . " NewcomersTeam='0', ";
    }
    if ($GreetingTeam == "on"){
        $sql = $sql . " GreetingTeam='1', ";
    }else{
        $sql = $sql . " GreetingTeam='0', ";
    }
    if ($SpecialEventsTeam == "on"){
        $sql = $sql . " SpecialEventsTeam='1', ";
    }else{
        $sql = $sql . " SpecialEventsTeam='0', ";
    }
    if ($ResourceTeam == "on"){
        $sql = $sql . " ResourceTeam='1', ";
    }else{
        $sql = $sql . " ResourceTeam='0', ";
    }
    if ($SmallGroupTeam == "on"){
        $sql = $sql . " SmallGroupTeam='1', ";
    }else{
        $sql = $sql . " SmallGroupTeam='0', ";
    }
    if ($StepStudyTeam == "on"){
        $sql = $sql . " StepStudyTeam='1', ";
    }else{
        $sql = $sql . " StepStudyTeam='0', ";
    }
    if ($TransportationTeam == "on"){
        $sql = $sql . " TransportationTeam='1', ";
    }else{
        $sql = $sql . " TransportationTeam='0', ";
    }
    if ($WorshipTeam == "on"){
        $sql = $sql . " WorshipTeam='1', ";
    }else{
        $sql = $sql . " WorshipTeam='0', ";
    }
    if ($LandingTeam == "on"){
        $sql = $sql . " LandingTeam='1', ";
    }else{
        $sql = $sql . " LandingTeam='0', ";
    }
    if ($CelebrationPlaceTeam == "on"){
        $sql = $sql . " CelebrationPlaceTeam='1', ";
    }else{
        $sql = $sql . " CelebrationPlaceTeam='0', ";
    }
    if ($SolidRockTeam == "on"){
        $sql = $sql . " SolidRockTeam='1', ";
    }else{
        $sql = $sql . " SolidRockTeam='0', ";
    }
    if ($MealTeam == "on"){
        $sql = $sql . " MealTeam='1',";
    }else{
        $sql = $sql . " MealTeam='0',";
    }
    if ($Chips == "on"){
        $sql = $sql . " Chips='1',";
    }else{
        $sql = $sql . " Chips='0',";
    }
    if ($CRImen == "on"){
        $sql = $sql . " CRImen='1',";
    }else{
        $sql = $sql . " CRImen='0',";
    }
    if ($CRIwomen == "on"){
        $sql = $sql . " CRIwomen='1'";
    }else{
        $sql = $sql . " CRIwomen='0'";
    }
    $sql = $sql . " WHERE ID ='" . $newID . "'";
    
    /* ------------------------------------
     * now head out of here....
     * ------------------------------------
     */

    
    // -------------------------------
    // determine where to go...
    // -------------------------------
    switch ($_GET['Origin']){
        case "grpForm":
            // send them back to the grpForm where they came from
            $tmp = "grpForm.php?Action=Edit&GID=" . $_GET['GID'] . "&MID=" . $_GET['MID'];
            break;
        case "ldrForm":
            // send them back to the trnForm where they came from
            $tmp = "ldrForm.php?Action=Edit&ID=" . $_GET['ID'];
            break;
        case "peepForm":
            $tmp = "mtgForm.php";
            break;
        default:
            if ($TID > 0){
                $tmp = "people.php?Action=TraineeList&TID=" . $TID;
            }else{
                $tmp = "people.php";
            }
            break;
    }
    executeSQL($sql, $tmp);
    //testSQL($sql);
}




function addPeepToDatebase(){
    
}
function executeSQL($sql,$destination){
    /* 
     * this function executes the sql passed in 
     */
   
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($con,$sql);

    mysqli_close($con);
    
    destination(307, $destination);
    
}
function dropPeepFromDatabase($PID){
    /***************************************************
     *  there are a few things to check before just
     *  deleting a user from the system. If they have
     *  any records in the system, we will need to update
     *  reference to reflect "removed user".
     *****************************************************/
    /******************************************************
     * get the "removed user" id from the people table
     *****************************************************/
    /******************************************************
     * update all the references with stored procedure
     *      changePIDReferenes(new, old)
     *****************************************************/
    /******************************************************
     * delete old PID from People table
     * 
     *****************************************************/
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    OR die(mysql_error());
    
    
    $sql = "DELETE FROM trainees WHERE TID='" . $TID . "' AND PID='" . $PID . "'";
    
    $tmp = "people.php";
    // executeSQL($sql, $tmp);
    testSQL($sql);
}

function testSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
   echo "SQL: " . $sql;
}

function bookTraineeInClass($TID, $PID){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    
    $sql = "INSERT INTO trainees (TID, PID) VALUES ('";
    $sql = $sql . $TID . "', '";
    $sql = $sql . $PID . "')";
    
    $tmp = "ldrForm.php?ID=" . $TID;
    executeSQL($sql, $tmp);
    // testSQL($sql);
}

function dropTraineeFromClass($TID, $PID){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    
    $sql = "DELETE FROM trainees WHERE TID='" . $TID . "' AND PID='" . $PID . "'";
    
    $tmp = "ldrForm.php?ID=" . $TID;
    executeSQL($sql, $tmp);
    // testSQL($sql);
}

?>
