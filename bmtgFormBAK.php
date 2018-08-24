<?php
require_once('authenticate.php'); /* for security purposes */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'database.php';
// ---------------------------------------------------
// meeterBase.php
// ---------------------------------------------------
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
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)" href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)" href="css/screen_layout_medium.css" />
<style type="text/css">


</style>
<link
	href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
	rel="stylesheet"/>

<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script src="js/jquery/jquery-ui.js" type="text/javascript"></script>

<!-- Javascript -->
<script type="text/javascript">
         $(function() {
            $( "#mtgDate" ).datepicker();
            $( "input[type='radio']" ).checkboxradio();
			$( "#btnCancel" ).button({
				label: "ta-da"
			});
            $( "#btnSubmit" ).button({
				label: "ta-DO"
            });
         });
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
							<div class="mtgLabels style="float:left"">Date:&nbsp;
							<input type = "text" id = "mtgDate"></div>
    						</td>
						</tr>
                      	<tr>
                      		<td colspan="2">
                          	<fieldset>
                              <legend>Meeting Type</legend>
                              <label for="radio-1">Lesson</label>
                              <input type="radio" name="radio-1" id="radio-1">
                              <label for="radio-2">Testimony</label>
                              <input type="radio" name="radio-1" id="radio-2">
                              <label for="radio-3">Special</label>
                              <input type="radio" name="radio-1" id="radio-3">
                            </fieldset>
                			</td>
            			</tr>
            			<tr>
            				<td><div class="mtgLabels" style="float:right">Title:&nbsp;</div></td>
                			<td><input id="mtgTitle" size="40" type="text"/></td>
            			</tr>
            			<tr>
							<td>
							<div class="mtgLabels" style="float:right">Host:</div></td>
							<td>
							<select id="mtgFacilitator" name="mtgFacilitator">
								<option value="57">Andy Hobbs</option>
								<option value="36">Becky Moore</option>
								<option value="35">Ben Edison</option>
								<option value="34">Billy Hamilton</option>
								<option value="56">Butler Caldwell</option>
							</select>
    						</td>
						</tr>
                		<tr>
							<td>
							<div class="mtgLabels" style="float:right">Worship:</div></td>
							<td>
							<select id="mtgWorship" name="mtgWorship">
								<option value="57">Andy Hobbs</option>
								<option value="56">Butler Caldwell</option>
								<option value="60">Eli Radney</option>
								<option value="32">Erin Russo</option>
								<option value="63">John Chancy</option>
							</select>
    						</td>
						</tr>	
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Attendance:</div></td>
							<td>
							<select id="mtgAttendance" name="mtgAttendance">
								<option value="0" selected>0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
    						</td>
						</tr>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Donations:</div></td>
							<td><input id="mtgDonations" size="6" type="text"/></td>
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
						<tr>
							<td colspan="2">
								<table border="3">
									<tr><td>
            							<div class="mtgCare" style="float:right">Nursery:
            							<select id="mtgNurseryCnt" name="mtgNurseryCnt">
            								<option value="0" selected>0</option>
            								<option value="1">1</option>
            								<option value="2">2</option>
            								<option value="3">3</option>
            								<option value="4">4</option>
            							</select></div></td>
            							<td>&nbsp;&nbsp;Coordinator:&nbsp;<select id="mtgFacilitator" name="mtgFacilitator">
            								<option value="57">Andy Hobbs</option>
            								<option value="36">Becky Moore</option>
            								<option value="35">Ben Edison</option>
            								<option value="34">Billy Hamilton</option>
            								<option value="56">Butler Caldwell</option>
            							</select>
                						</td>
            						</tr>
            						<tr>
            							<td>
            							<div class="mtgCare" style="float:right">Children:
            							<select id="mtgChildrenCnt" name="mtgChildrenCnt" style="float:right">
            								<option value="0" selected>0</option>
            								<option value="1">1</option>
            								<option value="2">2</option>
            								<option value="3">3</option>
            								<option value="4">4</option>
            							</select></div>
            							</td>
            							<td>&nbsp;&nbsp;Coordinator:&nbsp;<select id="mtgFacilitator" name="mtgFacilitator">
            								<option value="57">Andy Hobbs</option>
            								<option value="36">Becky Moore</option>
            								<option value="35">Ben Edison</option>
            								<option value="34">Billy Hamilton</option>
            								<option value="56">Butler Caldwell</option>
            							</select>
                						</td>
            						</tr>
            						<tr>
            							<td>
            							<div class="mtgCare" style="float:right">Youth:
            							<select id="mtgYouthCnt" name="mtgYouthCnt">
            								<option value="0" selected>0</option>
            								<option value="1">1</option>
            								<option value="2">2</option>
            								<option value="3">3</option>
            								<option value="4">4</option>
            							</select></div>
            							</td>
            							<td>&nbsp;&nbsp;Coordinator:&nbsp;<select id="mtgYouthCoordinator" name="mtgFacilitator">
            								<option value="57">Andy Hobbs</option>
            								<option value="36">Becky Moore</option>
            								<option value="35">Ben Edison</option>
            								<option value="34">Billy Hamilton</option>
            								<option value="56">Butler Caldwell</option>
            							</select>
            							</td>
        							</tr>
    							</table>	
    						</td>
						</tr>
						<tr><td colspan="2">
							<fieldset>
                              	<legend>Notes and Comments</legend>
                            	<textarea id="mtgNotes" rows="5" cols="50"></textarea>
                        	</fieldset>
                            </td></tr>	
                            <tr><td colspan="2">
                            	<input type="button" id="btnCancel" value="Cancel Button"/>&nbsp;&nbsp;
                            	<input type="button" id="btnSubmit" value="Commit In"/>
                            	
                            	<button type='button' id='cancelButtonOld' onclick='ExitPeopleForm()'>&nbsp;Cancel&nbsp;</button>
                            	&nbsp;&nbsp;
    							<button type="button" id="submitButtonOld" onclick='validateForm()' value='update'>Update Record</button>
           					</td>
       					</tr>
					</table>
			</form>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
	</body>
</html>
