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
    <meta name="description" content="">
    <meta name="author" content="Badge-It Gadget Lite Badger">

		<link rel="stylesheet" href="../css/style.css">
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js" type="text/javascript"></script>

		<script type="text/javascript">
			function isEmailAddress(str, id) {
			    var filter = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
			    if(String(str).search (filter) == -1) {
			    	alert('Email Address does not appear to be valid');
			    	document.getElementById(id).style.backgroundColor = "#FFCCCC";
				} else {
			    	document.getElementById(id).style.backgroundColor = "#E0E0E0";
				}
			    return String(str).search (filter) != -1;
			}
			function isEmpty(str, id) {
				if(str.length <= 0) {
					alert('This field is required and cannot be empty');
			    	document.getElementById(id).style.backgroundColor = "#FFCCCC";
				} else {
			    	document.getElementById(id).style.backgroundColor = "#E0E0E0";
				}
			}
			function checkBadge() {
				var e = document.getElementById("badge_info");
				var str = e.options[e.selectedIndex].text;
				if(str.indexOf("Soon -") > 0) {
					alert('This badge cannot be issued yet');
				}
			}
			function buildForm() {
				var count = document.getElementById("how_many").value;
				var checked = document.getElementById("dblCheck").checked;
				if (count.length > 0 && checked == true) {
					count = parseInt(count) + 1;
					var exampledata = "Mary Smith\tme@abc.com\thttp://myfunwork.abc.com\r\nJet Lee\tyou@sesame.edu\thttp://yourfunwork.sesame.edu\r\nEnrique Sanchez\thim@highplaces.gov\thttp://hisfunwork.highplaces.gov\r\n\r\n1\tme@abc.com\thttp://myfunwork.abc.com\r\n2\tyou@sesame.edu\thttp://yourfunwork.sesame.edu\r\n3\thim@highplaces.gov\thttp://hisfunwork.highplaces.gov\r\n\r\n1\tme@abc.com\r\n2\tyou@sesame.edu\r\n3\thim@highplaces.gov";
					setValue(exampledata);
					var form = '<form action="post"><div><img src="BadgeSubmissionExamples.png" /></div><div><h4>Copying and pasting from Excel</h4></div><div><span class="required">Step 1.</span> Paste the data from Excel into the box below<br /><textarea id="txtExcel" onclick="selectAll()" onchange="setValue(this.value);" cols="75" rows="5">' + exampledata + '</textarea></div>';

					//form += '<div><input type="button" value="Copy into Form Below" onclick="formatCells()" /></div>';
					form += '<div><br /><span class="required">Step 2.</span> <a onclick="formatCells()" style="cursor: pointer; font-weight: bold;">Click here to insert the copied data into form below</a><br /><br /></div>';
					form += '<div style="font-weight: bold; margin-left: 15px; width: 200px; float: left;"><span class="required">*</span> NAME or NUMBER</div>';
					form += '<div style="font-weight: bold; margin-left: 10px; width: 200px; float: left;"><span class="required">*</span> EMAIL ADDRESS</div>';
					form += '<div style="font-weight: bold; margin-left: 5px; width: 200px; float: left;">BADGE EXPERIENCE URL (remember to include http://)</div>';
					for (x = 1; x < count; x++) {
						form += '<div class="formRow" style="clear: both; height: 35px; width: 750px; border: solid 1px #CCCCCC;">' + "\r\n";
						form += '	<div style="font-size: 9pt; font-weight: bold; float:">Recipient ' + x + '</div>' + "\r\n";
						form += '	<div style="float: left;">' + "\r\n";
						form += '		<input type="text" onblur="isEmpty(this.value, this.id);" style="width: 180px;" id="badge_recipient_name_' + x + '" name="badge_recipient_name_' + x + '" required />' + "\r\n";
						form += '	</div>' + "\r\n";
						form += '	<div style="float: left;">' + "\r\n";
						form += '		<input type="text" onblur="isEmailAddress(this.value, this.id);" style="width: 180px;" id="badge_recipient_email_' + x + '" name="badge_recipient_email_' + x + '" required />' + "\r\n";
						form += '	</div>' + "\r\n";
						form += '	<div style="float: left;">' + "\r\n";
						form += '		<input type="text" style="width: 300px;" id="badge_experience_url_' + x + '" name="badge_experience_url_' + x + '" />' + "\r\n";
						form += '	</div>' + "\r\n";
						form += '</div>' + "\r\n";
					}
					form += '</form>';
					document.getElementById("theForm").innerHTML = form;
				} else {
					var msg = "";
					if(count.length <= 0) {
						msg += "You must specify how many badges are to be awarded.\r\n";
					}
					if(checked == false) {
						msg += "You must confirm that you have selected the correct badge.";
					}
					alert(msg);
				}
			}
		</script>
  </head>

  <body>
	
		<div>
			
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
		
		<form id="badgerForm" method="post" action="gadget2.php">
		
		<?php
		$directions = '
			<h2>Badge Request Form for Educators and NASA Staff</h2>
			<!--div style="margin-bottom: 10px;">Enter the number of people for whom you are requesting badges. It’s ok if you over-estimate. This is required to display enough entry boxes. You can also always come back in to submit more badge requests.</div>
			<div style="margin-bottom: 10px;">Select The badge you wish to issue.  Double Check the name as some badges have similar names. Click Generate Form button.</div>
			<div style="margin-bottom: 10px;">Enter the First and Last Names and Email addresses of your badge Recipients. Email addresses are required to send badges to the correct person\'s Open Badge Backpack.</div>
			<div style="margin-bottom: 10px;">The <b>Badge Experience URL</b> box is optional. If there are images, abstracts, videos, etc. posted somewhere, you can share the link to give viewers additional information. If you have a URL, be sure to include the "http://"" in the address.</div>
			<div style="margin-bottom: 10px;">Click the "Click Award Badges" button at the bottom of the form to submit.</div-->
		';
		print $directions;

		//Set up the badge select drop down
		$badge_select = '<span class="required">*</span> 1.  <label for="theissuer">Enter your name:</label> <input type="text" class="submit" style="margin-bottom: 10px; width: 365px; height: 30px; text-align: center;" id="theissuer" name="theissuer" />';
		$badge_select .= '<br /><span class="required">*</span> 2.  <label for="badge_info">Select a badge to issue:</label> <select id="badge_info" style="margin-bottom: 10px;" name="badge_info" onchange="checkBadge()">';
		
		for ($i = 1; $i <= count($badges_array); ++$i) {
			if ($i == $bf['posted_form_data']['badgeId']) {
				$badge_select .= '<option value="' . $i . '" selected>' . $badges_array[$i]['name'] . '</option>';	
			}
			else {
				$badge_select .= '<option value="' . $i . '">' . $badges_array[$i]['name'] . '</option>';
			}	
		}

		$badge_select .= '</select>';
		$doublecheck = '<br /><span class="required">*</span> 3.  <label for="doublecheck">Please double-check the Badge name as several names are similar.<br />&nbsp;&nbsp;&nbsp;<input type="checkbox" style="width: 20px; height: 20px;" id="dblCheck" /></label> Check means badge name is correct.';
		$howMany = '<br /><span class="required">*</span> 4.  <label for="how_many">How many badges to award:</label> <input type="text" class="submit" style="width: 50px; height: 30px; text-align: center;" maxlength="3" id="how_many" /> <input type="button" style="width: 125px;" value="Generate Form" onclick="buildForm();" />';
		$copyPaste = '<br /><span class="required">*</span> 5.  Copy and paste badge earner info [do not include headers] <b>OR</b> enter individual earner data in the gray boxes.';
		
		?>
			<div class="formRow"><?php print $badge_select; print $doublecheck; print $howMany; print $copyPaste; ?></div>
			<div id="theForm"></div>
			<!--div style="font-size: smaller;"><b>NOTE:</b> We do not store Recipient Names or email address that are submitted.  We only keep a count of how many badges have been awarded.</div-->
			<div class="formRow"><span class="required">*</span> 6. <input class="submit" style="width: 200px; height: 30px;" id="submit-button" type="submit" value="Click to Award Badges"/></div>
		</form>

		<script type="text/javascript">
			var theValue = '';
			function setValue(val){
				theValue = val;
				//alert(theValue);
			}
			function selectAll(){
				document.getElementById('txtExcel').focus();
				document.getElementById('txtExcel').select();
			}
			function formatCells(){
				var arrRows = theValue.split("\n");
				var j = 1;
				for(var i=0;i<arrRows.length;i++){
					var arrGroup = arrRows[i].split("\t");
					if(typeof arrGroup[0] != "undefined" && typeof arrGroup[1] != "undefined") {
						document.getElementById('badge_recipient_name_' + j).value = ((typeof arrGroup[0] == "undefined") ? "" : arrGroup[0]);
						document.getElementById('badge_recipient_email_' + j).value = ((typeof arrGroup[1] == "undefined") ? "" : arrGroup[1]);
						document.getElementById('badge_experience_url_' + j).value = ((typeof arrGroup[2] == "undefined") ? "" : arrGroup[2]);
						j++;
					}
				}
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
