<?php 

//Badge-It Gadget Lite v0.5.0 - Simple scripted system to award and issue badges into Mozilla Open Badges Infrastructure
//Copyright (c) 2012 Kerri Lemoie, Codery - gocodery.com
//Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php

/*The form to award the badge to your earner. Award a badge one by one. When you submit the form, the request is processed by gadget.php which will return a link for your earner to retrieve the badge.*/

session_start(); 

include 'gadget-settings.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Badge-It Gadget Lite Badger</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Auto-badging Web form for a web quiz or game">
    <meta name="author" content="Badge-It Gadget Lite Badger">

	<!--link rel="stylesheet" href="../css/style.css"-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js" type="text/javascript"></script>
	<style type="text/css">
		* { background-color: #fff; font-family: Arial; }
		.container { margin: 0 auto; }
		.required { color: #f00; }
		div { margin: 5px 50px; }
	</style>
  </head>

  <body class="container" onload="setBadge();">
	
		<div class="container">
			
		<!--<header>
			<H1>Gadget Badger</H1>
		</header>-->
	
		<?php 
			//Get session info retruned from gadget.php
		
			if(isset($_SESSION['bf_returndata'])) { 
				$bf = $_SESSION['bf_returndata'];
			}
		
			if ($bf['success']) {
				print $bf['success'];
			}
		
			if ($bf['errors']) {
				print $bf['errors']; 
			}
		?>
	
		<!-- Gadget Badger Form -->
		
		<form id="badgerForm" method="post" action="gadget.php">
		
		<?php
		//Set up the badge select drop down
		$badge_select = '<label for="badge_info">Badge Title</label><br /><select id="badge_info" name="badge_info"> <option></option>';
		
		for ($i = 1; $i <= count($badges_array); ++$i) {
			if ($i == $bf['posted_form_data']['badgeId']) {
				//$badge_select .= '<option value="' . $i . '" selected>' . $badges_array[$i]['name'] . '</option>';	
			}
			else {
				//$badge_select .= '<option value="' . $i . '" disabled>' . $badges_array[$i]['name'] . '</option>';
			}	
			$badge_select .= '<option value="' . $i . '">' . $badges_array[$i]['name'] . '</option>';
		}

		$badge_select .= '</select>';

		$badge_select = '<label for="badge_info">Badge Title:</label> <label id="badge_name"></label><input type="hidden" id="badge_info" name="badge_info" />'

		?>
			<div class="formRow"><?php print $badge_select; ?></div>
			<!--<div class="formRow"><label>Recipient Name:<span class="required">*</span></label> <input type="text" id="name" name="badge_recipient_name" value="< ?php print $bf['posted_form_data']['badgeRecipient']?>" required></div>-->
			<div class="formRow">
				<label><span class="required">*</span> What is your email address? We need this to email you a certificate and information about badge pickup and the Mozilla backpack.</label>
				<br />
				<input type="text" style="width: 300px;" id="email" name="badge_recipient_email" value="<?php print $bf['posted_form_data']['badgeRecipientEmail']?>" required>
			</div>
			<div class="formRow" style="display: none;">
				<label>Badge Experience URL</label>
				<br />
				<input type="text" style="width: 300px;" name="badge_experience_url" value="<?php print $bf['posted_form_data']['badgeExperienceUrl']?>" >
			</div>
			<div class="formRow">
				<label><span class="required">*</span> Which best describes you?</label>
				<br />
				<input type="radio" name="rbDesc" value="5-12" required>Student age 5-12
				<input type="radio" name="rbDesc" value="13-18" required>Student age 13-18 
				<input type="radio" name="rbDesc" value="Educator" required>Educator 
				<input type="radio" name="rbDesc" value="Adult" required>Other Adult learner 
			</div>
			<div class="formRow">
				<input class="submit" id="submit-button" type="submit" value="Submit"/>
				<input type="button" id="btnCancel" value="Cancel" onclick="window.parent.Shadowbox.close();" />
			</div>
		</form>
		
	<script type="text/javascript">
		function getQueryVariable(variable) {
		    var query = window.location.search.substring(1);
		    var vars = query.split('&');
		    for (var i = 0; i < vars.length; i++) {
		        var pair = vars[i].split('=');
		        if (decodeURIComponent(pair[0]) == variable) {
		            return decodeURIComponent(pair[1]);
		        }
		    }
		}
		function setBadge() {
			var theBadge = getQueryVariable('badge');
			var elem = document.getElementById('badge_info');
			var txt = "";
			switch(theBadge) {
				case 'Badge-ItGadgetLiteBadge':
					id = 1;
					txt = "Badge-It Gadget Lite Badge";
					break;
				case "AnotherBadge":
					id = 12;
					txt = "Another Badge";
					break;
			}
			elem.value = id;
			document.getElementById('badge_name').innerText = txt;
			/*for(var i=0; i<elem.options.length; i++){
				if(elem.options[i].text == txt) {
					elem.options[i].defaultSelected = true;
					elem.selectedIndex = i;
				} else {
					elem.options[i].style.display = "none";
					elem.disabled = true;
				}
			}*/
		}
	</script>
		<?php
			echo $_SESSION["mailResult"];
			unset($_SESSION["mailResult"]);
			unset($_SESSION['bf_returndata']);
		?>
		</div>
	
	</body>
	
</head>
