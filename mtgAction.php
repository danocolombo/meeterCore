<?php
include 'mtgRedirects.php';
include 'database.php';
require 'meeter.php';

/*
 * mtgAction.php
 */
$Action = $_GET['Action'];

switch ($Action){
    case "New":
        addMeetingToDB();
        exit;
    case "Update":
        updateMeetingInDB();
        exit;
    case "DeleteGroup":
        deleteGroup();
        exit;
    case "PreLoadGroups":
        $MID = $_GET['MID'];
        PreLoadGroups($MID);
        exit;
    default:
        echo "not sure what to do with " . $Action;
        
}

function addMeetingToDB(){
    /* 
     * this routine addes the form information to the database
     */
    /* need the following $link command to use the escape_string function */

    //since the add sql statement might be quite large dependind on the application
    // configuration, we will do it in parts.
    //------------------------------
    // start with required fields
    //------------------------------
    
    $mtg = new meeting($_POST['mtgDate'], $_POST['rdoMtgType'], $_POST['mtgTitle']);
    $mtg->setHost($_Post['mtgCoordinator']);
    $mtg->setAttendance($_POST['mtgAttendance']);
    $mtg->setNotes($_POST['mtgNotes']);
    //-------------------------------------------------
    // check configuration on what to expect.

    if($mtrConfig->getWorship()){
        $mtg->setWorship($_POST['mtgWorship']);
    }else{
        $mtg->setWorship = NOBODY;
    } 
    if($mtrConfig->getAV()){
        $mtg->setAv($_POST['mtgAV']);
    }else{
        $mtg->setAv(NOBODY);
    }
    if($mtrConfig->getGreeters()){
        $mtg->setGreeter1($_POST['mtgGreeter1']);
        $mtg->setGreeter2($_POST['mtgGreeter2']);
    }else{
        $mtg->setGreeters1(NOBODY);
        $mtg->setGreeters2(NOBODY);
    }
    if($mtrConfig->getResources()){
        $mtg->setResources($_POST['mtgResources']);
    }else{
        $mtg->setResources(NOBODY);
    }
    if($mtrConfig->getReaders()){
        $mtg->setReader1($_POST['mtgReader1']);
        $mtg->setReader2($_POST['mtgReader2']);
    }else{
        $mtg->setReader1(NOBODY);
        $mtg->setReader2(NOBODY);
    }
    if($mtrConfig->getAnnouncements()){
        $mtg->setAnnouncements($_POST['mtgAnnouncements']);
    }else{
        $mtg->setAnnouncements(NOBODY);
    }
    if($mtrConfig->getChips()){
        $mtg->setChips1($_POST['mtgChips1']);
        $mtg->setChips2($_POST['mtgChips2']);
    }else{
        $mtg->setChips1(NOBODY);
        $mtg->setChips2(NOBODY);
    }
    if($mtrConfig->getSerenity()){
        $mtg->setSerenity($_POST['mtgSerenity']);
    }else{
        $mtg->setSerenity(NOBODY);
    }
    if($mtrConfig->getCafe()){
        $mtg->setCafe($_POST['mtgCafe']);
    }else{
        $mtg->setCafe(NOBODY);
    }
    if($mtrConfig->getDonations()){
        $mtg->setDonationAmount($_POST['mtgCafe']);
    }else{
        $mtg->setDonationAmount("0.00");
    }
    if($mtrConfig->getMeal()){
        $mtg->setMeal($_POST['mtgMeal']);
        $mtg->setMealGuests($_POST['mtgMealCnt']);
    }else{
        $mtg->setMeal("");
        $mtg->setMealGuests("");
    }
    if($mtrConfig->getMealFac()){
        $mtg->setMealFac($_POST['mtgMealFac']);
    }else{
        $mtg->setDonationAmount("0");
    }
    if($mtrConfig->getNursery()){
        $mtg->setNursery($_POST['mtgNurseryCnt']);
    }else{
        $mtg->setNursery("0");
    }
    if($mtrConfig->getNurseryFac()){
        $mtg->setNurseryFac($_POST['mtgNurseryFac']);
    }else{
        $mtg->setNurseryFac("0");
    }
    if($mtrConfig->getChildren()){
        $mtg->setChildren($_POST['mtgChildrenCnt']);
    }else{
        $mtg->setChildren("0");
    }
    if($mtrConfig->getChildrenFac()){
        $mtg->setChildrenFac($_POST['mtgChildrenFac']);
    }else{
        $mtg->setChildrenFac("0");
    }
    if($mtrConfig->getYouth()){
        $mtg->setYouth($_POST['mtgYouthCnt']);
    }else{
        $mtg->setYouth("0");
    }
    if($mtrConfig->getYouthFac()){
        $mtg->setYouthFac($_POST['mtgYouthFac']);
    }else{
        $mtg->setYouthFac("0");
    }
    if($mtrConfig->setup()){
        $mtg->setSetup($_POST['mtgSetup']);
    }else{
        $mtg->setSetup("0");
    }
    if($mtrConfig->teardown()){
        $mtg->setTeardown($_POST['mtgTearDown']);
    }else{
        $mtg->setTeardown("0");
    }
    if($mtrConfig->transportation()){
        $mtg->setTransportation($_POST['mtgTransportation']);
    }else{
        $mtg->setTransportation("0");
    }
    if($mtrConfig->security()){
        $mtg->setSecurity($_POST['mtgSecurity']);
    }else{
        $mtg->setSecurity("0");
    }
    
    echo "ALL DONE INSERTING NEW MEETING..hahaha";
    exit;
    //#############################
//     $tmp = "meetings.php";
//     executeSQL($sql,$MID);
    /*testSQL($sql); */
    
    
    
    
    
    
    
    
    
//      $stmt->bind_param("sss", $mtgDate, $mgtType, $$mtgTitle );
//      // Create connection
//      $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//      // Check connection
//      if ($conn->connect_error) {
//          die("Connection failed: " . $conn->connect_error);
//      }
     
//      $stmt = $connection->prepare("Select ID FROM meetings WHERE MtgDate = ? AND MtgType = ? AND MtgTitle = ?");
//      if ($result->num_rows > 0) {
//          // output data of each row
//          while($row = $result->fetch_assoc()) {
//              echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//          }
//      } else {
//          echo "0 results";
//      }
//      $conn->close();
            
            
            
            
            
            
//     $mDate = $_POST['mtgDate'];
//     $mType = $_POST['mtgType'];
//     $mTitle = $_POST['mtgTitle'];
//     $mPresenter = $_POST['mtgPresenter'];
//     $mWorship = $_POST['mtgWorship'];
//     $mAttendance = $_POST['mtgAttendance'];
//     $mMeal = $_POST['mtgMeal'];
//     $mDinnerCnt = $_POST['mtgDinnerCnt'];
//     $mDonations = $_POST['mtgDonations'];
//     $mNurseryCnt = $_POST['mtgNurseryCnt'];
//     $mChildrenCnt = $_POST['mtgChildrenCnt'];
//     $mYouthCnt = $_POST['mtgYouthCnt'];
//     $mNotes = $_POST['mtgNotes'];
    
//     $sql = "INSERT INTO meetings (MtgDate, MtgType, MtgTitle, MtgPresenter, MtgWorship, MtgAttendance,
//         Donations, MtgMeal, DinnerCnt, NurseryCnt, ChildrenCnt, YouthCnt, MtgNotes) VALUES ('";
//     $sql = $sql . $mDate . "', '" . $mType . "', '";
//     $sql = $sql . mysql_real_escape_string($mTitle) . "', '"; 
//     $sql = $sql . mysql_real_escape_string($mPresenter) . "', '"; 
//     $sql = $sql . $mWorship . "', '";
//     $sql = $sql . $mAttendance . "', '";
//     $sql = $sql . $mDonations . "', '";
//     $sql = $sql . mysql_real_escape_string($mMeal) . "', '";
//     $sql = $sql . $mDinnerCnt . "', '";
//     $sql = $sql . $mNurseryCnt . "', '";
//     $sql = $sql . $mChildrenCnt . "', '";
//     $sql = $sql . $mYouthCnt . "', '";
//     $sql = $sql . mysql_real_escape_string($mNotes) . "')";
    
    $tmp = "meetings.php";
    executeSQL($sql,$MID);
    /*testSQL($sql); */
}

function updateMeetingInDB(){
    /* 
     * this routine updates an existing record in the database
     */
    /* need the following $link command to use the escape_string function */
    include 'database.php';
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
    
    
    $ID = $_GET['ID']; 
    $mDate = $_POST['mtgDate'];
    $mType = $_POST['mtgType'];
    $mTitle = $_POST['mtgTitle'];
    $mPresenter = $_POST['mtgPresenter'];
    $mWorship = $_POST['mtgWorship'];
    $mAttendance = $_POST['mtgAttendance'];
    $mDonations = $_POST['mtgDonations'];
    $mMeal = $_POST['mtgMeal'];
    $mDinnerCnt = $_POST['mtgDinnerCnt'];
    $mNurseryCnt = $_POST['mtgNurseryCnt'];
    $mChildrenCnt = $_POST['mtgChildrenCnt'];
    $mYouthCnt = $_POST['mtgYouthCnt'];
    $mNotes = $_POST['mtgNotes'];
    
    $sql = "UPDATE meetings SET MtgDate = '";
    $sql = $sql . $mDate . "', MtgType = '";
    $sql = $sql . $mType . "', MtgTitle = '";
    $sql = $sql . mysql_real_escape_string($mTitle) . "', MtgPresenter = '";
    $sql = $sql . mysql_real_escape_string($mPresenter) . "', MtgAttendance = '";
    $sql = $sql . $mAttendance . "', ";
    $sql = $sql . "MtgWorship = '";
    $sql = $sql . $mWorship . "', ";
    $sql = $sql . "Donations = ";
    $sql = $sql . $mDonations . ", ";
    $sql = $sql . "MtgMeal = '";
    $sql = $sql . mysql_real_escape_string($mMeal) . "', ";
    $sql = $sql . "DinnerCnt = '" . $mDinnerCnt . "', ";
    $sql = $sql . "NurseryCnt = '" . $mNurseryCnt . "', ";
    $sql = $sql . "ChildrenCnt = '" . $mChildrenCnt . "', ";
    $sql = $sql . "YouthCnt = '" . $mYouthCnt . "', ";
    $sql = $sql . "MtgNotes = '" . mysql_real_escape_string($mNotes) . "'";
    $sql = $sql . " WHERE ID = '" . $ID . "'";
    
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con,$sql);

    mysqli_close($con);
    $dest = "meetings.php";
    //testSQL($sql);
    destination(307, $dest);
}

function deleteGroup(){
/*==========================================================
    this routine deletes the group from the ID passed in
==========================================================*/
    $id = $_GET['GID'];
    
    // need to ensure that we have a GID
    if ($id > 0){
        $sql = "DELETE FROM groups WHERE ID = " . $id;
        
        $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        // Check connection
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        mysqli_query($con,$sql);

        mysqli_close($con);
        $dest = "mtgForm.php?ID=" . $_GET['MID'];
        //testSQL($sql);
        destination(307, $dest);
    
        
    }
    
}
function PreLoadGroups($MID){
    /*======================================================================
     * this function copies the groups from the previous meeting to the 
     * meeting ID passed in.
     ======================================================================*/
    $dbcon=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if (mysqli_connect_errno()){    
        die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_error() . ")");
    }
    /*#############################################
     * GET THE LAST MEETING ID TO GET GROUPS FROM
     *############################################*/
    $query = "SELECT ";
    $query .= "groups.MtgID ";
    $query .= "FROM groups ";
    $query .= "INNER JOIN ";
    $query .= "meetings ON groups.MtgID = meetings.ID ";
    $query .= "ORDER BY meetings.MtgDate DESC";
    // echo "<br />" . $query . "<br /><hr /";
    $result = mysqli_query($dbcon, $query);
    if (!result){
        die("Database query failed.");
    }
    $grpIDs = mysqli_fetch_assoc($result);
    $lastMtgID = $grpIDs["MtgID"];
    mysqli_free_result($result); 
    // echo "<br />lastMtgID=" . $lastMtgID . "<br/>";
    /*****************************************************
     * Now get the groups from that last meeting in array
     * ===================================================
     * we need:
     *      FacID
     *      CoFacID
     *      Gender
     *      Location
     *      Title
     * ===================================================
     *****************************************************/
    $query = "SELECT ";
    $query .= "groups.FacID, groups.CoFacID, groups.Gender, ";
    $query .= "groups.Location, groups.Title ";
    $query .= "FROM groups ";
    $query .= "WHERE groups.MtgID = " . $lastMtgID . " ";
    $query .= "ORDER BY groups.Gender, groups.Title";
    $result = mysqli_query($dbcon, $query);
    $group = array();
    $FacID = array();
    $CoFacID = array();
    $Gender = array();
    $Location = array();
    $Title = array();
    
    if (!result){
        die("Database query failed.");
    }
    $grpCnt = 0;
    while($groups = mysqli_fetch_assoc($result)){
        /*========================================/
         * now load array with groups retrieved
         *****************************************/
        $FacID[$grpCnt] = $groups["FacID"];
        $CoFacID[$grpCnt] = $groups["CoFacID"];
        $Gender[$grpCnt] = $groups["Gender"];
        $Location[$grpCnt] = $groups["Location"];
        $Title[$grpCnt] = $groups["Title"];
        ++$grpCnt;
    }
    mysqli_free_result($result); 
    $i = 0;
    while ($i < $grpCnt){
        /*****************************
         * print group
         *****************************/
        //echo $Gender[$i] . " " . $Title[$i] . " in " . $Location[$i] . "<br/>";
        ++$i;
    }
    /***********************************
     * insert data for new week
     ***********************************/
    $i = 0;
    while ($i < $grpCnt){
        $query = "INSERT INTO groups (FacID, CoFacID, Gender, Title, Location, MtgID)
            Values({$FacID[$i]}, {$CoFacID[$i]}, {$Gender[$i]}, '{$Title[$i]}',
                '{$Location[$i]}', {$MID})";
               
        //echo "query:" . $query . "<br/><hr />";        
        $result = mysqli_query($dbcon, $query);
        if (!$result){
            die("Database query INSERT failed");    
        }
        ++$i;
    }
    
    mysqli_close($dbcon);
    $dest = "mtgForm.php?ID=" . $MID;
    destination(307, $dest);
}

function executeSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
    include 'database.php';
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con,$sql);

    
    mysqli_close($con);
    
    destination(307, "meetings.php");
    
}

function testSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
   echo "SQL: " . $sql;
}
?>
