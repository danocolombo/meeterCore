<?php 
require_once('authenticate.php'); /* this is used for security purposes */
require 'meeter.php';
require 'mtrAOS.php';
// need to get the configuration settings from the database
$mtrConfig->getLatestConfig();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
		<link rel="stylesheet" type="text/css" href="css/jqbase/jquery-ui.theme.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css" />
		
		<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
		<script src="js/jqbase/jquery-ui.js" type="text/javascript"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script>
          	$( function() {
            	$( "#accordion" ).accordion();
          	} );
      	</script>
		<script type="text/javascript">
			function validateForm(){
				
				$( "#dialog-confirm" ).dialog({
					  closeText: "x",
				      resizable: false,
				      height: "auto",
				      width: 400,
				      modal: true,
				      buttons: {
				        "Submit": function() {
				        	document.getElementById("adminMtrForm").submit();

// 				        	var dest = "adminMeeterAction.php?Action=UpdateAOS";
// 							window.location.href=dest;
// 				          $( this ).dialog( "close" );
				        },
				        "Cancel": function() {
					          $( this ).dialog( "close" );
				        },
				        "Exit without Saving": function() {
				          $( this ).dialog( "close" );
				          cancelForm();
				        }
				      }
			    });

			}
			function cancelForm(){
				var dest = "index.php";
				window.location.href=dest;
			}
      	</script>
      	
      	
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
				<a class="logo" title="home" href="index.php"><span></span></a>
			</header>
			<nav>
				<a href="meetings.php">Meetings</a>
				<a href="people.php">People</a>
				<a href="teams.php">Teams</a>
				<a href="leadership.php">Leadership</a>
				<a href="reportlist.php">Reporting</a>
				<a href="#">ADMIN</a>
				<a href="logout.php">[ LOGOUT ]</a>
			</nav>
			<article>
				<form id="adminMtrForm" action="adminMeeterAction.php?Action=UpdateAOS" method="post">
				<H2>Meeter Meeting Configuration</H2>
				<div>You can configure what features you want to manage simply by
				clicking the checkbox and saving.</div>
				<div id="accordion">
                  <h3>Preparation</h3>
                  <div>
                    <p>
                    In this section you can configure the basics for planning and getting ready.
                    </p>
                    <p>
                    <?php 
                    //===========================
                    // get fresh data to begin
                    //===========================
                    $aosConfig->loadConfigFromDB();
                    echo "<table>";
                    echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                    if($aosConfig->getConfig("setup") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cbSetup\" value=\"Setup\" id=\"cbSetup\" CHECKED>&nbsp;Setup</td>";
                        echo "<td><input type=\"text\" name=\"tbSetup\" value=\"" . $aosConfig->getDisplayString("setup") . "\"></td></tr>";
                    }else{
                        echo "<tr><td><input type=\"checkbox\" name=\"cbSetup\" value=\"Setup\" id=\"cbSetup\">&nbsp;Setup</td>";
                        echo "<td><input type=\"text\" name=\"tbSetup\" value=\"" . $aosConfig->getDisplayString("setup") . "\"></td></tr>";
                    }
                    if($aosConfig->getConfig("worship") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cbWorship\" value=\"Worship\" id=\"cbWorship\" CHECKED>&nbsp;Worship</td>";
                        echo "<td><input type=\"text\" name=\"tbWorship\" value=\"" . $aosConfig->getDisplayString("worship") . "\"></td></tr>";
                    }else{
                        echo "<tr><td><input type=\"checkbox\" name=\"cbWorship\" value=\"Worship\" id=\"cbWorship\">&nbsp;Worship</td>";
                        echo "<td><input type=\"text\" name=\"tbWorship\" value=\"" . $aosConfig->getDisplayString("worship") . "\"></td></tr>";
                    }
                    if($aosConfig->getConfig("av") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cbAV\" value=\"AV\" id=\"cbAV\" CHECKED>&nbsp;Audio/Visual</td>";
                        echo "<td><input type=\"text\" name=\"tbAV\" value=\"" . $aosConfig->getDisplayString("av") . "\"></td></tr>";
                    }else{
                        echo "<tr><td><input type=\"checkbox\" name=\"cbAV\" value=\"AV\" id=\"cbAV\">&nbsp;Audio/Visual</td>";
                        echo "<td><input type=\"text\" name=\"tbAV\" value=\"" . $aosConfig->getDisplayString("av") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("greeter") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbGreeters\" value=\"Greeter\" id=\"cbGreeters\" CHECKED>&nbsp;Greeters</td>";
            		    echo "<td><input type=\"text\" name=\"tbGreeters\" value=\"" . $aosConfig->getDisplayString("greeter") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbGreeters\" value=\"Greeter\" id=\"cbGreeters\">&nbsp;Greeters</td>";
            		    echo "<td><input type=\"text\" name=\"tbGreeters\" value=\"" . $aosConfig->getDisplayString("greeter") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("resources") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbResources\" value=\"Resources\" id=\"cbResources\" CHECKED>&nbsp;Resources</td>";
            		    echo "<td><input type=\"text\" name=\"tbResources\" value=\"" . $aosConfig->getDisplayString("resources") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbResources\" value=\"Resources\" id=\"cbResources\">&nbsp;Resources</td>";
            		    echo "<td><input type=\"text\" name=\"tbResources\" value=\"" . $aosConfig->getDisplayString("resources") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("meal") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbMeal\" value=\"Meal\" id=\"cbMeal\" CHECKED>&nbsp;Meal attendance&nbsp;</td>";
            		    echo "<td>&nbsp;&nbsp;N/A</td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbMeal\" value=\"Meal\" id=\"cbMeal\">&nbsp;Meal attendance</td>";
            		    echo "<td>&nbsp;&nbsp;N/A</td></tr>";
            		}
            		if($aosConfig->getConfig("mealFac") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbMealFac\" value=\"MealFac\" id=\"cbResources\" CHECKED>&nbsp;Meal Coordiator</td>";
            		    echo "<td><input type=\"text\" name=\"tbMealFac\" value=\"" . $aosConfig->getDisplayString("mealFac") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbMealFac\" value=\"MealFac\" id=\"cbMealFac\">&nbsp;Meal Facilitator</td>";
            		    echo "<td><input type=\"text\" name=\"tbMealFac\" value=\"" . $aosConfig->getDisplayString("mealFac") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("transportation") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbTransportation\" value=\"Transportation\" id=\"cbTransportation\" CHECKED>&nbsp;transportation</td>";
            		    echo "<td><input type=\"text\" name=\"tbTransportation\" value=\"" . $aosConfig->getDisplayString("transportation") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cbTransportation\" value=\"Transportation\" id=\"cbTransportation\">&nbsp;transportation</td>";
            		    echo "<td><input type=\"text\" name=\"tbTransportation\" value=\"" . $aosConfig->getDisplayString("transportation") . "\"></td></tr>";
            		}
            		echo "</table>";
            		?>
                    </p>
                  </div>
                  <h3>Execution</h3>
                  <div>
                    <p>
                    These are the items related to the actual meeting:<br/>
                    <?php 
                        echo "<table>";
                        echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                        if($aosConfig->getConfig("reader") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbReaders\" value=\"Readers\" id=\"cbReaders\" CHECKED>&nbsp;Readers</td>";
                            echo "<td><input type=\"text\" name=\"tbReaders\" value=\"" . $aosConfig->getDisplayString("reader") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbReaders\" value=\"Readers\" id=\"cbReaders\" >&nbsp;Readers</td>";
                            echo "<td><input type=\"text\" name=\"tbReaders\" value=\"" . $aosConfig->getDisplayString("reader") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("announcements") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbAnnouncements\" value=\"Announcements\" id=\"cbAnnouncements\" CHECKED>&nbsp;Announcements</td>";
                            echo "<td><input type=\"text\" name=\"tbAnnouncements\" value=\"" . $aosConfig->getDisplayString("announcements") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbAnnouncements\" value=\"Announcements\" id=\"cbAnnouncements\">&nbsp;Announcements</td>";
                            echo "<td><input type=\"text\" name=\"tbAnnouncements\" value=\"" . $aosConfig->getDisplayString("announcements") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("chips") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbChips\" value=\"Chips\" id=\"cbChips\" CHECKED>&nbsp;Chip Ceremony</td>";
                            echo "<td><input type=\"text\" name=\"tbChips\" value=\"" . $aosConfig->getDisplayString("chips") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbChips\" value=\"Chips\" id=\"cbChips\">&nbsp;Chip Ceremony</td>";
                            echo "<td><input type=\"text\" name=\"tbChips\" value=\"" . $aosConfig->getDisplayString("chips") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("donations") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbDonations\" value=\"Donations\" id=\"cbDonations\" CHECKED>&nbsp;Donations&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbDonations\" value=\"Donations\" id=\"cbDonations\" >&nbsp;Donations&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }
                        if($aosConfig->getConfig("serenity") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbSerenity\" value=\"Serenity\" id=\"cbSerenity\" CHECKED>&nbsp;Serenity Prayer</td>";
                            echo "<td><input type=\"text\" name=\"tbSerenity\" value=\"" . $aosConfig->getDisplayString("serenity") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbSerenity\" value=\"Serenity\" id=\"cbSerenity\" >&nbsp;Serenity Prayer</td>";
                            echo "<td><input type=\"text\" name=\"tbSerenity\" value=\"" . $aosConfig->getDisplayString("serenity") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("newcomers") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbNewcomers\" value=\"Newcomers\" id=\"cbNewcomers\" CHECKED>&nbsp;Newcomers</td>";
                            echo "<td><input type=\"text\" name=\"tbNewcomers\" value=\"" . $aosConfig->getDisplayString("newcomers") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbNewcomers\" value=\"Newcomers\" id=\"cbNewcomers\" >&nbsp;Newcomers</td>";
                            echo "<td><input type=\"text\" name=\"tbNewcomers\" value=\"" . $aosConfig->getDisplayString("newcomers") . "\"></td></tr>";
                        }
                        echo "</table>";
                    ?>
                    </p>
                  </div>
                  <h3>Child Care &amp; Youth</h3>
                  <div>
                    <p>
                    This section relates to the plans for nursery, kids and youth
                    </p>
                    <p>
                    <?php 
                        echo "<table>";
                        echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                    
                        if($aosConfig->getConfig("nursery") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbNursery\" value=\"Nursery\" id=\"cbNursery\" CHECKED>&nbsp;Nursery Count&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbNursery\" value=\"Nursery\" id=\"cbNursery\" >&nbsp;Nursery Count&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }
                        if($aosConfig->getConfig("nurseryFac") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbNurseryFac\" value=\"NurseryFac\" id=\"cbNursery\" CHECKED>&nbsp;Nursery facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tbNurseryFac\" value=\"" . $aosConfig->getDisplayString("nurseryFac") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbNurseryFac\" value=\"NurseryFac\" id=\"cbNursery\" >&nbsp;Nursery facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tbNurseryFac\" value=\"" . $aosConfig->getDisplayString("nurseryFac") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("children") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbChildren\" value=\"Children\" id=\"cbChildren\" CHECKED>&nbsp;Children Count&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbChildren\" value=\"Children\" id=\"cbChildren\" CHECKED>&nbsp;Children Count&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }
                        if($aosConfig->getConfig("childrenFac") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbChildrenFac\" value=\"ChildrenFac\" id=\"cbChildrenFac\" CHECKED>&nbsp;Children Fac</td>";
                            echo "<td><input type=\"text\" name=\"tbChildrenFac\" value=\"" . $aosConfig->getDisplayString("childrenFac") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbChildrenFac\" value=\"ChildrenFac\" id=\"cbChildrenFac\" >&nbsp;Children Fac</td>";
                            echo "<td><input type=\"text\" name=\"tbChildrenFac\" value=\"" . $aosConfig->getDisplayString("childrenFac") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("youth") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbYouth\" value=\"Youth\" id=\"cbYouth\" CHECKED>&nbsp;Youth Count&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cbYouth\" value=\"Youth\" id=\"cbYouth\" >&nbsp;Youth Count&nbsp;</td>";
                            echo "<td>&nbsp;&nbsp;N/A</td></tr>";
                        }
                        if($aosConfig->getConfig("youthFac") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cbYouthFac\" value=\"YouthFac\" id=\"cbYouthFac\" CHECKED>&nbsp;Youth facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tbYouthFac\" value=\"" . $aosConfig->getDisplayString("youthFac") . "\"></td></tr>";
                        }else{
                            
                            echo "<tr><td><input type=\"checkbox\" name=\"cbYouthFac\" value=\"YouthFac\" id=\"cbYouthFac\" >&nbsp;Youth facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tbYouthFac\" value=\"" . $aosConfig->getDisplayString("youthFac") . "\"></td></tr>";
                        }
                        echo "</table>";
                    ?>
                    </p>
                  </div>
                  <h3>Wrap-up</h3>
                  <div>
                    <p>
                    This is all the items to conclude your General Meeting Night
                    </p>
                    <p>
                    <?php 
                    if($aosConfig->getConfig("cafe") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbCafe\" value=\"Cafe\" id=\"cbCafe\" CHECKED>&nbsp;Cafe<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbCafe\" value=\"Cafe\" id=\"cbCafe\" >&nbsp;Cafe<br>";
                        }
                        if($aosConfig->getConfig("teardown") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbTearDown\" value=\"TearDown\" id=\"cbTearDown\" CHECKED>&nbsp;Tear Down/Clean-up<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbTearDown\" value=\"TearDown\" id=\"cbTearDown\" >&nbsp;Tear Down/Clean-up<br>";
                        }
                        if($aosConfig->getConfig("security") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbSecurity\" value=\"Security\" id=\"cbSecurity\" CHECKED>&nbsp;Security<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbSecurity\" value=\"Security\" id=\"cbSecurity\" >&nbsp;Security<br>";
                        }
                    ?>
                    </p>
                  </div>
                  <h3>Misc/Others</h3>
                  <div>
                    <p>
                    These are generic roles and things you can track related to your ministry, but not necessarily on GMN.
                    </p>
                    <p>
                    <?php 
                    if($aosConfig->getConfig("fellowship") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbFellowship\" value=\"Fellowship\" id=\"cbFellowship\" CHECKED>&nbsp;Fellowship<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbFellowship\" value=\"Fellowship\" id=\"cbFellowship\" >&nbsp;Fellowship<br>";
                        }
                        if($aosConfig->getConfig("prayer") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbPrayer\" value=\"Prayer\" id=\"cbPrayer\" CHECKED>&nbsp;Prayer Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbPrayer\" value=\"Prayer\" id=\"cbPrayer\" >&nbsp;Prayer Team<br>";
                        }
                        if($aosConfig->getConfig("specialEvents") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbSpecialEvents\" value=\"SpecialEvents\" id=\"cbSpecialEvents\" CHECKED>&nbsp;Special Events Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbSpecialEvents\" value=\"SpecialEvents\" id=\"cbSpecialEvents\" >&nbsp;Special Events Team<br>";
                        }
                        if($aosConfig->getConfig("stepStudy") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbStepStudy\" value=\"StepStudy\" id=\"cbStepStudy\" CHECKED>&nbsp;Step Study Teams<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbStepStudy\" value=\"StepStudy\" id=\"cbStepStudy\" >&nbsp;Step Study Teams<br>";
                        }
                        if($aosConfig->getConfig("crim") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbCRIMen\" value=\"CRIMen\" id=\"cbCRIMen\" CHECKED>&nbsp;CRI Men Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbCRIMen\" value=\"CRIMen\" id=\"cbCRIMen\" >&nbsp;CRI Men Team<br>";
                        }
                        if($aosConfig->getConfig("criw") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbCRIWomen\" value=\"CRIWomen\" id=\"cbCRIWomen\" CHECKED>&nbsp;CRI Women Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbCRIWomen\" value=\"CRIWomen\" id=\"cbCRIWomen\" >&nbsp;CRI Women Team<br>";
                        }
                    ?>
                    </p>
                    
                  </div>

                </div>
              	<p>
                	<input type="button" id="btnCancel" value="Cancel Button"/>&nbsp;&nbsp;
                	<input type="button" id="btnSubmit" value="Commit In"/>
				</p>
                <script type="text/javascript">
                    // POST FORM SCRIPT
                    
                    $( "#btnCancel" ). button({
                        label: "Cancel"
                    });
                    $( "#btnCancel").click(function(){
        				cancelForm();
        			});
                    
                    $( "#btnSubmit" ).button({
        				label: "Save Settings",
                    });
        			$( "#btnSubmit").click(function(){
        				validateForm();
        			});
        			
              </script>
				</form>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
        <!-- The following div is the dialog that pops prior to submitting form. -->
        <div id="dialog-confirm" title="Configuration Confirmation">
          <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Your changes can impact what is managed for each meetting; what areas people can serve in and what teams are coordintated.<br/>Previous saved values will not be lost.</p>
        </div>
</body>
</html>