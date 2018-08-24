<?php
require_once('authenticate.php'); /* for security purposes */
require 'meeter.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'database.php';
// ---------------------------------------------------
// mtgForm 2.0
// ---------------------------------------------------
//
// get data
//-----------------------------------------------------
$MID = $_GET["ID"];
if ($MID > 0){
    /*------------------------------------------------
     * this section will get the meeting ID from the
     * url and display it for the user
     ===============================================*/
    //if($mysqli->errno > 0){
    if (mysqli_connect_errno()){
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_error() . ")");
    }
    $sql = "SELECT * FROM meetings WHERE ID = " . $MID;
    
    $mtg = array();
    
    $result = $mysqli->query($sql);
    
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $mtg[] = array($row['ID'], $row['MtgDate'], $row['MtgType'],
            $row['MtgTitle'], $row['MtgPresenter'], $row['MtgAttendance'],
            $row['MtgWorship'], $row['MtgMeal'], $row['DinnerCnt'],
            $row['NurseryCnt'], $row['ChildrenCnt'], $row['YouthCnt'],
            $row['MtgNotes'], $row['Donations'],$row['Reader1'], $row['Reader2'],
            $row['NurseryContact'],$row['ChildrenContact'], $row['YouthContact'],
            $row['MealContact'],$row['CafeContact'], $row['TransportationContact'],
            $row['SetupContact'],$row['TearDownContact'], $row['Greeter1'],
            $row['Greeter2'],$row['Resources'], $row['Serenity'],$row['AudioVisual'], 
            $row['Announcements'], $row['SecurityContact']
            
        );
    }
    
    //ordered data
    /*
     * ordered data
     *   0   ID
     *   1   MtgDate
     *   2   MtgType
     *   3   MtgTitle
     *   4   MtgPresenter
     *   5   MtgAttendance
     *   6   MtgWorship
     *   7   MtgMeal
     *   8   DinnerCnt
     *   9   NurseryCnt
     *   10   ChildrenCnt
     *   11   YouthCnt
     *   12   MtgNotes 
     *   13   Donations
     *   14   Reader1
     *   15   Reader2
     *   16   NurseryContact
     *   17   ChildrenContact
     *   18   YouthContact
     *   19   MealContact
     *   20   CafeContact
     *   21   TransportationContact
     *   22   SetupContact
     *   23   TearDownContact
     *   24   Greeter1
     *   25   Greeter2
     *   26   Resources
     *   27   Serenity
     *   28   AudioVisual
     *   29   Announcements
     *   30   Security
     *   
     */
    //---------------------------------------------
    // save data
    $mtgID = $mtg[0][0];
    $mtgDate = $mtg[0][1];
    $mtgType = $mtg[0][2];
    $mtgTitle = $mtg[0][3];
    $mtgPresenter = $mtg[0][4];
    $mtgAttendance = $mtg[0][5];
    $mtgWorship = $mtg[0][6];
    $mtgMeal = $mtg[0][7];
    $mtgDinnerCnt = $mtg[0][8];
    $mtgNurseryCnt = $mtg[0][9];
    $mtgChildrenCnt = $mtg[0][10];
    $mtgYouthCnt = $mtg[0][11];
    $mtgNotes = $mtg[0][12];
    $mtgDonations = $mtg[0][13];
    $mtgReader1 = $mtg[0][14];
    $mtgReader2 = $mtg[0][15];
    $mtgNurseryContact = $mtg[0][16];
    $mtgChildrenContact = $mtg[0][17];
    $mtgYouthContact = $mtg[0][18];
    $mtgMealContact = $mtg[0][19];
    $mtgCafeContact = $mtg[0][20];
    $mtgTransportationContact = $mtg[0][21];
    $mtgSetupContact = $mtg[0][22];
    $mtgTearDownContact = $mtg[0][23];
    $mtgGreeter1 = $mtg[0][24];
    $mtgGreeter2 = $mtg[0][25];
    $mtgResources = $mtg[0][26];
    $mtgSerenity = $mtg[0][27];
    $mtgAudioVisual = $mtg[0][28];
    $mtgAnnouncements = $mtg[0][29];
    $mtgSecurity = $mtg[0][30];
}
//==============================================   
// need to get team listings for drop down
//
if($mysqli->errno > 0){
    printf("Mysql error number generated: %d", $mysqli->errno);
    exit();
}
// $sql = "SELECT ID, FName, LName, TeachingTeam, WorshipTeam, NurseryTeam, CelebrationPlaceTeam, LandingTeam, ReaderTeam, Chips, SerenityTeam";
// $sql += " FROM `people` WHERE Active = 1 AND (";
// $sql += " GreetingTeam = 1 or ResourceTeam = 1 or TransportationTeam = 1 or WorshipTeam = 1 or LandingTeam = 1 or CelebrationPlaceTeam = 1 or SolidRockTeam = 1";
// $sql += " or MealTeam = 1 or TeachingTeam = 1 or GMNFacilitator = 1 or ChipsTeam = 1 or ReaderTeam = 1 or NurseryTeam = 1 or SerenityTeam = 1 or SetupTeam = 1";
// $sql += " or TearDownTeam = 1 or AudioVisual = 1 or Announcements = 1 or SecurityTeam = 1) AND ID != 0 ORDER BY FName";

$sql = "SELECT * FROM people WHERE ID > 0";
$peeps = array();
$result = $mysqli->query($sql);

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    $peeps[] = array($row['ID'], $row['FName'], $row['LName'],
        $row['GreetingTeam'], $row['ResourceTeam'], $row['TransportationTeam'], $row['WorshipTeam'],
        $row['LandingTeam'], $row['CelebrationPlaceTeam'], $row['SolidRockTeam'], $row['MealTeam'],
        $row['TeachingTeam'], $row['GMNFacilitator'], $row['Chips'], $row['ReaderTeam'],
        $row['NurseryTeam'], $row['SerenityTeam'], $row['SetupTeam'], $row['TearDownTeam'],
        $row['AudioVisual'], $row['Announcements'], $row['SecurityTeam']
    );
//     /*      array order
//      * 
//      *  0   ID
//      *  1   FName
//      *  2   LName
//      *  3   Greeters 1 & 2
//      *  4   Resource Team
//      *  5   TransportationTeam
//      *  6   WorshipTeam
//      *  7   Landing Team
//      *  8   CelebrationPlaceTeam
//      *  9   SolidRockTeam
//      *  10  MealTeam
//      *  11  TeachingTeam
//      *  12  GMNFacilitator
//      *  13  Chips
//      *  14  ReaderTeam
//      *  15  NurseryTeam
//      *  16  SerenityTeam
//      *  17  SetupTeam
//      *  18  TearDownTeam
//      *  19  AudioVisual
//      *  20  Announcements
//      *  21  Security
//      */
        
}
    
// all of our selectable areas...
$greeterPeeps = array();
$greeterPeeps[] = array("0", "Nobody");
$resourcePeeps = array();
$resourcePeeps[] = array("0", "Nobody");
$transportationPeeps = array();
$transportationPeeps[] = array("0", "Nobody");
$worshipPeeps[] = array();
$worshipPeeps[] = array("0", "Videos");
$youthPeeps[] = array();
$youthPeeps[] = array("0", "Nobody");
$childrenPeeps[] = array();
$childrenPeeps[] = array("0", "Nobody");
$cafePeeps[] = array();
$cafePeeps[] = array("0", "Nobody");
$mealPeeps[] = array();
$mealPeeps[] = array("0", "Nobody");
$teachingPeeps[] = array();
$teachingPeeps[] = array("0", "Nobody");
$GMNFacilitatorPeeps[] = array();
$GMNFacilitatorPeeps[] = array("0", "Nobody");
$chipPeeps[] = array();
$chipPeeps[] = array("0", "Nobody");
$readerPeeps[] = array();
$readerPeeps[] = array("0", "Nobody");
$nurseryPeeps[] = array();
$nurseryPeeps[] = array("0", "Nobody");
$serenityPeeps[] = array();
$serenityPeeps[] = array("0", "Nobody");
$setupPeeps[] = array();
$setupPeeps[] = array("0", "Nobody");
$tearDownPeeps[] = array();
$tearDownPeeps[] = array("0", "Nobody");
$avPeeps[] = array();
$avPeeps[] = array("0", "Nobody");
$announcementPeeps[] = array();
$announcementPeeps[] = array("0", "Nobody");
$securityPeeps[] = array();
$securityPeeps[] = array("0", "Nobody");
    
    
// lets loop through loading appropriate arrays
for($i = 0; $i < sizeof($peeps); $i++){
    //greeters
    if($peeps[$i][3] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $greeterPeeps[] = array($peeps[$i][0], $fullName);
    }
    //resources
    if($peeps[$i][4] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $resourcePeeps[] = array($peeps[$i][0], $fullName);
    }
    //transportation
    if($peeps[$i][5] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $transportationPeeps[] = array($peeps[$i][0], $fullName);
    }
    //worship
    if($peeps[$i][6] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $worshipPeeps[] = array($peeps[$i][0], $fullName);
    }
    //youth team
    if($peeps[$i][7] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $youthPeeps[] = array($peeps[$i][0], $fullName);
    }
    //children team
    if($peeps[$i][8] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $childrenPeeps[] = array($peeps[$i][0], $fullName);
    }
    //cafe team
    if($peeps[$i][9] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $cafePeeps[] = array($peeps[$i][0], $fullName);
    }
    //meal team
    if($peeps[$i][10] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $mealPeeps[] = array($peeps[$i][0], $fullName);
    }
    //teaching team
    if($peeps[$i][11] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $teachingPeeps[] = array($peeps[$i][0], $fullName);
    }
    //GMN facilitators
    if($peeps[$i][12] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $GMNFacilitatorPeeps[] = array($peeps[$i][0], $fullName);
    }
    //chip team
    if($peeps[$i][13] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $chipPeeps[] = array($peeps[$i][0], $fullName);
    }
    //reader team
    if($peeps[$i][14] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $readerPeeps[] = array($peeps[$i][0], $fullName);
    }
    //nursery team
    if($peeps[$i][15] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $nurseryPeeps[] = array($peeps[$i][0], $fullName);
    }
    //serenity team
    if($peeps[$i][16] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $serenityPeeps[] = array($peeps[$i][0], $fullName);
    }
    //setup team
    if($peeps[$i][17] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $setupPeeps[] = array($peeps[$i][0], $fullName);
    }
    //teardown team
    if($peeps[$i][18] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $tearDownPeeps[] = array($peeps[$i][0], $fullName);
    }
    //av team
    if($peeps[$i][19] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $avPeeps[] = array($peeps[$i][0], $fullName);
    }
    //announcements team
    if($peeps[$i][20] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $announcementPeeps[] = array($peeps[$i][0], $fullName);
    }
    //security team
    if($peeps[$i][21] == 1){
        $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
        $securityPeeps[] = array($peeps[$i][0], $fullName);
    }
}
    
//#############################################
//  END OF PRE-CONDITIONING
//#############################################

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
	<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<title>Meeter Web Application</title>
<link rel="stylesheet" type="text/css" href="css/vader/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)" href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)" href="css/screen_layout_medium.css" />

<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script src="js/jquery/jquery-ui.js" type="text/javascript"></script>

<!-- Javascript -->
<script type="text/javascript">
			function validateMtgForm(){
				// start with validating the date value
				var m_Date = $( "#mtgDate" ).datepicker('getDate');
				var m_NewDate = $("#mtgDate").datepicker({ dateFormat: 'yyyy,mm,dd'}).val();
				if(isValidDate(m_NewDate) == false){
					alert("please select an accurate date");
					$("#mtgDate").datepicker("setDate", new Date());
					$("#mtgDate").datepicker( "show" );
					return false;
				}
				var m_type = $('input[name=rdoMtgType]:checked').attr('id');
				if(m_type == "undefined"){
					alert("Please select the type of meeting you are entering");
					return false;
				}
				switch(m_type){
				case "rdoLesson":
					m_type = "Lesson";
					alert("It is a Lesson");
					break;
				case "rdoTestimony":
					m_type = "Testimony";
					alert("It is a testimony");
					break;
				case "rdoSpecial":
					m_type = "Special"
					alert("oh, that is special");
					break;
				default:
					alert("This is not expected");
					return false;
					break;
				}
				var recordID = getUrlVars()["ID"];
				if (recordID.length<1){
					// no record value, must be an add request;
					alert("this is an update");
				}
				alert(m_type);
				if($("#mtgTitle").val().length<4){
					alert("you need to provide a title longer than 3 characters");
					$("#mtgTitle").focus();
					return false;
				}
				alert("STOP");
				return false;
				var recordID = getUrlVars()["ID"];
				var dest = "mtgAction.php?Action=Update&ID=" + recordID;
// 				window.location.href=dest;
			}
			function cancelMtgForm(){
				var dest = "meetings.php";
				window.location.href=dest;
			}

			function isValidDate(dateString){
				// First check for the pattern
			    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
			        return false;

			    // Parse the date parts to integers
			    var parts = dateString.split("/");
			    var day = parseInt(parts[1], 10);
			    var month = parseInt(parts[0], 10);
			    var year = parseInt(parts[2], 10);

			    // Check the ranges of month and year
			    if(year < 1000 || year > 3000 || month == 0 || month > 12)
			        return false;

			    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

			    // Adjust for leap years
			    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
			        monthLength[1] = 29;

			    // Check the range of the day
			    return day > 0 && day <= monthLength[month - 1];
			}
			
			function importedValidation(){
				// if user is trying to delete system user "Removed User", then echo message that
				// action is not possible. 
				//--------------------------------------------------------------------------------
				var mDate = $("mtgDate").value;
				alert(mDate);
				var FName = document.forms["peepForm"]["peepFName"].value;
				var LName = document.forms["peepForm"]["peepLName"].value;
				if(FName == "Removed" && LName == "User"){
					// user is trying to delete system entry. Post warning and abort
					alert("The entry you are trying to delete is used by the system, and can\'t be removed");
					return false;
				}
				//check if the current user is set to active
				var aFlag = document.getElementById("peepActive").checked;
				if(aFlag == true){
					alert("It is recommended you make the person \'inactive\' rather than deleting.");
					var x = confirm("Press OK if you want to really delete. All references in the system will be lost");
					if (x == true){
						var recordID = getUrlVars()["PID"];
						var newURL = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
						window.location.href=newURL;
						return true;	
					}else{
						return false;
					}
				}
				var x2 = confirm("Click \'OK\' if you are sure you want to delete this user.");
				if (x2 == true){
					var recordID = getUrlVars()["PID"];
					//alert(recordID);
					//alert("DELETE");
					var dest = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
					window.location.href=dest;
				}else{
					alert("Delete User aborted.");
					return false;
				}
			}
			function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			        vars[key] = value;
			    });
			    return vars;
			}
        </script>
<script type="text/javascript" src="js/farinspace/jquery.imgpreload.min.js"></script>
</head>
<body>
	<div class="page">
		<header>
			<div id="hero"></div>
			<a class="logo" title="home" href="index.php"><span></span></a>
		</header>
		<nav>
			<a href="meetings.php">Meetings</a> <a href="people.php">People</a> <a
				href="teams.php">Teams</a> <a href="leadership.php">Leadership</a> <a
				href="reportlist.php">Reporting</a> <a href="#">ADMIN</a> <a
				href="logout.php">[ LOGOUT ]</a>
		</nav>
		<article>
			<form id="mtgForm" action="mtgAction.php?Action=New" method="post">
				<h2 id="formTitle">New Meeting Entry</h2>
					<table id="formTable">
						<tr>
							<td colspan="2">
							<div class="mtgLabels">Date:&nbsp;
							<input type = "text" id = "mtgDate"></div>
    						</td>
						</tr>
                      	<tr>
                      		<td colspan="2">
                          	<fieldset>
                              <legend>Meeting Type</legend>
                              <label for="rdoLesson">Lesson</label>
                              <?php 
                                  if($mtgType == "Lesson"){
                                      echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoLesson\" value=\"Lesson\" checked=\"checked\">";
                                  }else{
                                      echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoLesson\" value=\"Lesson\" >";
                                  }
                              ?>                             
                              <label for="rdoTestimony">Testimony</label>
                              <?php 
                                  if($mtgType == "Testimony"){
                                    echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoTestimony\" value=\"Testimony\" checked=\"checked\">";
                                  }else{
                                      echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoTestimony\" value=\"Testimony\" >";
                                  }
                              ?>
                              <label for="rdoSpecial">Special</label>
                              <?php 
                                    if($mtgType == "Special"){
                                  	     echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoSpecial\" value=\"Special\" checked=\"checked\">";
                                  	}else{
                                  		echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoSpecial\" value=\"Special\" >";
                              		}
                      		    ?>
                            </fieldset>
                			</td>
            			</tr>
            			<tr>
            				<td><div class="mtgLabels" style="float:right">Title:&nbsp;</div></td> 
                			<td><input id="mtgTitle" size="40" style="font-size:14;" type="text" value="<?php echo $mtgTitle;?>"/></td>
            			</tr>
            			<tr>
							<td>
							<div class="mtgLabels" style="float:right">Host:</div></td>
							<td>
							<select id="mtgCoordinator" name="mtgCoordinator">
    							<?php 
    								for($i = 0; $i < sizeof($hostPeeps); $i++){
    								    if($mtgPresenter==$hostPeeps[$i][0]){
    								        echo "<option value=\"" . $hostPeeps[$i][0] . "\" selected>" . $hostPeeps[$i][1] . "</option>";
    								    }else{
    								        echo "<option value=\"" . $hostPeeps[$i][0] . "\">" . $hostPeeps[$i][1] . "</option>";
    								    }
    								}
    								
								?>
							</select>
    						</td>
						</tr>
						<?php 
    						if($mtrConfig->getWorship()){
    						    //================================
    						    //    WORSHIP IS TRUE = DISPLAY OPTION
					    ?>	
                    		<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Worship:</div></td>
    							<td>
    							<select id="mtgWorship" valign="center" name="mtgWorship">
    								<?php 
    								    //echo "<option disabled selected>Please pick one</option>";
        								for($i = 0; $i < sizeof($worshipPeeps); $i++){
        								    if($mtgWorship == $worshipPeeps[$i][0]){
        								        echo "<option value=\"" . $worshipPeeps[$i][0] . "\" selected>" . $worshipPeeps[$i][1] . "</option>";
        								    }else{
        								        echo "<option value=\"" . $worshipPeeps[$i][0] . "\">" . $worshipPeeps[$i][1] . "</option>";
        								    }
        								}
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Worship team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Worship
						?>
						<?php 
    						if($mtrConfig->getAV()){
    						    //================================
    						    //    AV IS TRUE = DISPLAY OPTION
					    ?>	
                    		<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Audio/Visual:</div></td>
    							<td>
    							<select id="mtgAV" name="mtgAV">
    								<?php 
    								    //echo "<option disabled selected>Please pick one</option>";
        								for($i = 0; $i < sizeof($avPeeps); $i++){
        								    if($mtgWorship == $avPeeps[$i][0]){
        								        echo "<option value=\"" . $avPeeps[$i][0] . "\" selected>" . $avPeeps[$i][1] . "</option>";
        								    }else{
        								        echo "<option value=\"" . $avPeeps[$i][0] . "\">" . $avPeeps[$i][1] . "</option>";
        								    }
        								}								
    								?>
    							</select>
    							<a href="#" valign="center" title="People on A/V team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for AV
						?>
						<?php 
						if($mtrConfig->getGreeters()){
						    //================================
						    //    GREETER IS TRUE = DISPLAY OPTION
					    ?>	
                    		<tr>
    							<td>
    							<div class="mtgGreeter1" style="float:right">Greeters:</div></td>
    							<td>
    							<select id="mtgGreeter1" name="mtgGreeter1">
    								<?php 
    								    //echo "<option disabled selected>Please pick one</option>";
        								for($i = 0; $i < sizeof($greeterPeeps); $i++){
        								    if($mtgGreeter1 == $greeterPeeps[$i][0]){
        								        echo "<option value=\"" . $greeterPeeps[$i][0] . "\" selected>" . $greeterPeeps[$i][1] . "</option>";
        								    }else{
        								        echo "<option value=\"" . $greeterPeeps[$i][0] . "\">" . $greeterPeeps[$i][1] . "</option>";
        								    }
        								}								
    								?>
    							</select>
    							<select id="mtgGreeter2" name="mtgGreeter2">
    								<?php 
    								    //echo "<option disabled selected>Please pick one</option>";
        								for($i = 0; $i < sizeof($greeterPeeps); $i++){
        								    if($mtgGreeter2 == $greeterPeeps[$i][0]){
        								        echo "<option value=\"" . $greeterPeeps[$i][0] . "\" selected>" . $greeterPeeps[$i][1] . "</option>";
        								    }else{
        								        echo "<option value=\"" . $greeterPeeps[$i][0] . "\">" . $greeterPeeps[$i][1] . "</option>";
        								    }
        								}								
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Greeting team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Greeter
						?>
						<?php 
    						if($mtrConfig->getResources()){
    						    //================================
    						    //    RESOURCES IS TRUE = DISPLAY OPTION
					    ?>	
                    		<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Resources:</div></td>
    							<td>
    							<select id="mtgResources" name="mtgResources">
    								<?php 
    								    //echo "<option disabled selected>Please pick one</option>";
        								for($i = 0; $i < sizeof($resourcePeeps); $i++){
        								    if($mtgWorship == $resourcePeeps[$i][0]){
        								        echo "<option value=\"" . $resourcePeeps[$i][0] . "\" selected>" . $resourcePeeps[$i][1] . "</option>";
        								    }else{
        								        echo "<option value=\"" . $resourcePeeps[$i][0] . "\">" . $resourcePeeps[$i][1] . "</option>";
        								    }
        								}								
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Resource team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for RESOURCES
						?>
						<?php 
						if($mtrConfig->getReaders()){
						    //================================
						    //    READERS IS TRUE = DISPLAY OPTION
					    ?>	
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Readers:</div></td>
    							<td>
    							<select id="mtgReader1" name="mtgReader1">
    								<?php 
        								for($i = 0; $i < sizeof($readerPeeps); $i++){
        								    echo "<option value=\"" . $readerPeeps[$i][0] . "\">" . $readerPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
    							&nbsp;
    							<select id="mtgReader2" name="mtgReader2">
    								<?php 
        								for($i = 0; $i < sizeof($readerPeeps); $i++){
        								    echo "<option value=\"" . $readerPeeps[$i][0] . "\">" . $readerPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Reading team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Readers
						?>
						<?php 
						if($mtrConfig->getAnnouncements()){
						    //================================
						    //    ANNOUNCEMENTS IS TRUE = DISPLAY OPTION
					    ?>	
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Announcements:</div></td>
    							<td>
    							<select id="mtgAnnouncements" name="mtgAnnouncements">
    								<?php 
        								for($i = 0; $i < sizeof($readerPeeps); $i++){
        								    echo "<option value=\"" . $announcementPeeps[$i][0] . "\">" . $announcementPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Announcement team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Announcements
						?>
						<?php 
						if($mtrConfig->getChips()){
						    //================================
						    //    CHIPS IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Chips:</div></td>
    							<td>
    							<select id="mtgChips1" name="mtgChip1">
    								<?php 
        								for($i = 0; $i < sizeof($chipPeeps); $i++){
        								    echo "<option value=\"" . $chipPeeps[$i][0] . "\">" . $chipPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							&nbsp;
    							<select id="mtgChips2" name="mtgChip2">
    								<?php 
        								for($i = 0; $i < sizeof($chipPeeps); $i++){
        								    echo "<option value=\"" . $chipPeeps[$i][0] . "\">" . $chipPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Chips team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Chips
						?>
						<?php 
						if($mtrConfig->getSerenity()){
						    //================================
						    //    Serenity IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Serenity:</div></td>
    							<td>
    							<select id="mtgSerenity" name="mtgSerenity">
    								<?php 
    								for($i = 0; $i < sizeof($serenityPeeps); $i++){
        								    echo "<option value=\"" . $serenityPeeps[$i][0] . "\">" . $serenityPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Serenity team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Serenity
						?>
						<?php 
						if($mtrConfig->getCafe()){
						    //================================
						    //    CAFE IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Cafe:</div></td>
    							<td>
    							<select id="mtgCafe" name="mtgCafe">
    								<?php 
    								for($i = 0; $i < sizeof($cafePeeps); $i++){
    								    echo "<option value=\"" . $cafePeeps[$i][0] . "\">" . $cafePeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Cafe team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for CAFE
						?>
						<tr><td colspan="2"><hr/></td></tr>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Attendance:</div></td>
							<td>
							<select id="mtgAttendance" name="mtgAttendance">
								<?php 
    								for($a = 0; $a<201; $a++){
    								    if($a == $mtgAttendance){
    								        echo "<option value=\"" . $a . "\" selected>" . $a . "</option>";
    								    }else{
    								        echo "<option value=\"" . $a . "\">" . $a . "</option>";
    								    }
    								}
								?>
							</select>
    						</td>
						</tr>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Donations:</div></td>
							<td><input id="mtgDonations" size="6" type="text" placeholder="$ 0"/></td>
						</tr>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Meal:</div></td>
							<td><input id="mtgMeal" size="30" type="text"/><select id="mtgMealCnt" name="mtgMealCnt">
								<option value="0" selected>0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
							</td>
						</tr>
						<?php 
						if($mtrConfig->getMealFac()){
						    //================================
						    //    MEAL FACILITATOR IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Meal Coordinator:</div></td>
    							<td>
    							<select id="mtgMealFac" name="mtgMealFac">
    								<?php 
    								for($i = 0; $i < sizeof($mealPeeps); $i++){
    								    echo "<option value=\"" . $mealPeeps[$i][0] . "\">" . $mealPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Meal team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for MEAL FACILITATOR
						?>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2">
								<table border="3">
									<tr><td>
            							<div class="mtgCare" style="float:right">Nursery:
            							<select id="mtgNurseryCnt" name="mtgNurseryCnt">
            								<?php 
            								for($i = 0; $i < 31; $i++)	{
            								    echo "<option value=\"" . $i . "\">" . $i . "</option>";
            								}
            								?>
            							</select></div></td>
            							<td>&nbsp;&nbsp;Facilitator:&nbsp;<select id="mtgNurseryFac" name="mtgNurseryFac">
            								<?php 
                								for($i = 0; $i < sizeof($nurseryPeeps); $i++){
                								    echo "<option value=\"" . $nurseryPeeps[$i][0] . "\">" . $nurseryPeeps[$i][1] . "</option>";
                								}								
            								?>
            							</select>
            							<a href="#" valign="center" title="People on Nursery team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
                						</td>
            						</tr>
            						<tr>
            							<td>
            							<div class="mtgCare" style="float:right">Children:
            							<select id="mtgChildrenCnt" name="mtgChildrenCnt" style="float:right">
            								<?php 
            								for($i = 0; $i < 31; $i++)	{
            								    echo "<option value=\"" . $i . "\">" . $i . "</option>";
            								}
            								?>
            							</select></div>
            							</td>
            							<td>&nbsp;&nbsp;Facilitator:&nbsp;<select id="mtgChildrensFac" name="mtgChilrensFac">
            								<?php 
                								for($i = 0; $i < sizeof($childrenPeeps); $i++){
                								    echo "<option value=\"" . $childrenPeeps[$i][0] . "\">" . $childrenPeeps[$i][1] . "</option>";
                								}								
            								?>
            							</select>
            							<a href="#" valign="center" title="People on Children team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
                						</td>
            						</tr>
            						<tr>
            							<td>
            							<div class="mtgCare" style="float:right">Youth:
            							<select id="mtgYouthCnt" name="mtgYouthCnt">
            								<?php 
            								for($i = 0; $i < 31; $i++)	{
            								    echo "<option value=\"" . $i . "\">" . $i . "</option>";
            								}
            								?>
            							</select></div>
            							</td>
            							<td>&nbsp;&nbsp;Facilitator:&nbsp;<select id="mtgYouthFac" name="mtgYouthFac">
            								<?php 
                								for($i = 0; $i < sizeof($youthPeeps); $i++){
                								    echo "<option value=\"" . $youthPeeps[$i][0] . "\">" . $youthPeeps[$i][1] . "</option>";
                								}								
            								?>
            							</select>
            							<a href="#" valign="center" title="People on Youth team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
            							</td>
        							</tr>
    							</table>	
    						</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<?php 
						if($mtrConfig->getSetup()){
						    //================================
						    //    SETUP IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Setup Coordinator:</div></td>
    							<td>
    							<select id="mtgSetup" name="mtgSetup">
    								<?php 
    								for($i = 0; $i < sizeof($setupPeeps); $i++){
    								    echo "<option value=\"" . $setupPeeps[$i][0] . "\">" . $setupPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Setup team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Setup
						?>
						<?php 
						if($mtrConfig->getTeardown()){
						    //================================
						    //    TearDown IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Tear Down/Clean-up:</div></td>
    							<td>
    							<select id="mtgTearDown" name="mtgTearDown">
    								<?php 
    								for($i = 0; $i < sizeof($tearDownPeeps); $i++){
    								    echo "<option value=\"" . $tearDownPeeps[$i][0] . "\">" . $tearDownPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Clean-up team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for TearDown
						?>
						<?php 
						if($mtrConfig->getTransportation()){
						    //================================
						    //    Transportaion IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Transportation:</div></td>
    							<td>
    							<select id="mtgTransportation" name="mtgTransportation">
    								<?php 
    								for($i = 0; $i < sizeof($transportationPeeps); $i++){
    								    echo "<option value=\"" . $transportationPeeps[$i][0] . "\">" . $transportationPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Transportation team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Transportion
						?>
						<?php 
						if($mtrConfig->getSecurity()){
						    //================================
						    //    Security IS TRUE = DISPLAY OPTION
					    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Security:</div></td>
    							<td>
    							<select id="mtgSecurity" name="mtgSecurity">
    								<?php 
    								for($i = 0; $i < sizeof($securityPeeps); $i++){
    								    echo "<option value=\"" . $securityPeeps[$i][0] . "\">" . $securityPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							<a href="#" valign="center" title="People on Security team"><img style="width:15px;height:15px;" src="images/toolTipQM.png"/></a>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Security
						?>
						<tr><td colspan="2">
							<fieldset>
                              	<legend>Notes and Comments</legend>
                            	<textarea id="mtgNotes" rows="5" cols="50"></textarea>
                        	</fieldset>
                            </td></tr>	
                            <tr><td colspan="2">
                            	<input type="button" id="btnCancel" value="Cancel Button"/>&nbsp;&nbsp;
                            	<input type="button" id="btnSubmit" value="Commit In"/>
           					</td>
       					</tr>
					</table>
			</form>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
		<script type="text/javascript">
         $(function() {
            $("#mtgDate").datepicker({
                showAnim: "blind",
                numberOfMonths: 1,
                showWeek: false,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                minDate: new Date(2013, 1 - 1, 1),
                maxDate: new Date(2020, 12 - 1, 31)
            });
            <?php 
                //date from db is in format: YYYY-MM-DD
                if (sizeof($mtgDate)>0){
                    $mYear = substr($mtgDate, 0, 4);
                    $mMonth = substr($mtgDate, 5, 2);
                    $mDay = substr($mtgDate, 8, 2);
                
                    echo "$(\"#mtgDate\").datepicker(\"setDate\", new Date(" . $mYear . ", " . $mMonth . " - 1, " . $mDay . "));";
                }else{
                    echo "$(\"#mtgDate\").datepicker(\"setDate\", new Date());";
                }
            ?>
            // MEETING TYPE
            $( "input[type='radio']" ).checkboxradio();
            $("#radios").buttonset();

            //$( "#mtgWorship" ).selectMenu();
            
			// ATTENDANCE SPINNER
            	//var x = <?php echo $mtgAttendance; ?>;
            //$( "#spnrAttendance" ).spinner("value", x );
			//$( "#spnrAttendance" ).spinner("value", 5 );
			
            // CANCEL BUTTON
            $( "#btnCancel" ). button({
                label: "Cancel"
            });
            //$("#btnCancel").button("option", "label", "Cancel");

            // SUBMIT BUTTON
            $( "#btnSubmit" ).button({
				label: "Submit",
            });
			$( "#btnSubmit").click(function(){
				validateMtgForm();
			});
			$( "#btnCancel").click(function(){
				cancelMtgForm();
			});
         });
      </script>
	</body>
</html>
?>