<?php

//Badge-It Gadget Lite v0.5.0 - Simple scripted system to award and issue badges into Mozilla Open Badges Infrastructure
//Copyright (c) 2012 Kerri Lemoie, Codery - gocodery.com
//Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php

/*This script creates the badge for the user. and provides the link to get-my-badge.php which interacts with open badges*/

include 'gadget-settings.php';

function rand_string( $length ) { //this function just obscures the users name and badge in the url get string 
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	
	return $str;
}


if( isset($_POST) ){
	$errors = "<h4>Could not send email to the following recipient(s):</h4>";
	$successes = "<h4>Successfully sent email to the following recipient(s):</h4>";
	
	//set all variables
	
	$badgeId 				= $_POST['badge_info'];
	$badgeRecipientName 	= $_POST['badge_recipient_email'];
	$badgeRecipientEmail 	= $_POST['badge_recipient_email'];
	$badgeExperienceURL 	= $_POST['badge_experience_url'];
	$badgeName 				= $badges_array[$badgeId]['name'];
	$thebadge = $badgeName;
	$badgeImage				= $badges_array[$badgeId]['image'];
	$badgeDescription		= $badges_array[$badgeId]['description'];
	$badgeCriteria			= $badges_array[$badgeId]['criteria_url'];
	$badgeExpires			= $badges_array[$badgeId]['expires'];	
	$date = date('Y-m-d');
	$err = '';
	$msg = '';
	
	//salt email	
	$salt = rand_string(8); //randomized everytime
	$hashed_email = hash('sha256', $badgeRecipientEmail  . $salt);

	//creates JSON file - will write over an existing badge for same badge and same user.

	//$filename = str_rot13($badgeId.'-'. preg_replace("/ /","_",$badgeRecipientName));
	$filename = str_rot13($badgeId.'-'. preg_replace("/ /","_",md5($badgeRecipientEmail)));
	
	$jsonFilePath = $json_dir . $filename .'.json';

	$handle = fopen($jsonFilePath, 'w');
	$fileData = array(
		'recipient' => "sha256$".$hashed_email,
		'salt' => $salt,
		'evidence' => $badgeExperienceURL,
		'issued_on'=> $date,
		'badge' => array(
			'version' => '0.5.0',
			'name' => $badgeName,
			'image' => $issuer_url.$badge_images_dir.$badgeImage,
			'description' => $badgeDescription,
			'criteria' => $badgeCriteria,
			'expires' => $badgeExpires,
			'issuer' => array(
				'origin' => $issuer_url,
				'name' => $issuer_name,
				'org' => $issuer_org,
				'contact' => $issuer_contact,
			)
		)
	);
	
	//Writes JSON file
	
	if (fwrite($handle, json_encode($fileData)) === FALSE) {
        $err = '<div class="badge-error">Cannot write to file ($jsonFilePath). Please check your \$json_dir in gadget_settings.php</div>';
	} else { //Sucess message and write badge to badge_records.txt file
		$getMyBadgeURL = $issuer_url.'/badge-it-gadget-lite/digital-badges/get-my-badge.php?id='.$filename;
		//$msg = '<div class="badge-link-success">Your badge is ready to be issued. Go to this link to retrieve your badge: <a href="'.$issuer_url.'/badge-it-gadget-lite/digital-badges/get-my-badge.php?id='.$filename.'">'.$issuer_url.'/badge-it-gadget-lite/digital-badges/get-my-badge.php?id='.$filename.'</a></div>';
		$msg = '<script type="text/javascript"> alert("Your badge is ready to be issued. Check your email to get your badge."); parent.Shadowbox.close(); </script>';
		fclose($handle);
		
	//Writes to badge_records.txt file
		
		$badgeRecordsFile = $root_path . $badge_records_file;
	
		$badgeHandle = fopen($badgeRecordsFile, 'a'); 
		$badge_data = "BADGE AWARDED: ".$date.", ".$badgeName.", ".$jsonFilePath.", ".$hashed_email.", ".$badgeCriteria;
	
		if (! empty($badgeExperienceURL)) {
			$badge_data .= ", ".$badgeExperienceURL;
		}
	
		$badge_data .= "\n";
	
		if (fwrite($badgeHandle, $badge_data) === FALSE) {
  		$err .= '<div class="badge-error">Cannot write to file ('.$badgeRecordsFile.'). Please check your $root and $badge_records_file in gadget_settings.php. Your JSON file was created but the badge was not recorded.</div>';
  	}
	
	 	fclose($badgeHandle);
		
		if(strlen($badgeName) > 1) {}

		$to = $badgeRecipientEmail;
		$from = "badges@cet.edu";
		if($_POST["rbDesc"] == "5-12") {
			$subject = "Your " . $badgeName . " Certificate";
			$message = 'Congratulations!

You have successfully completed the ' . $badgeName . ' challenge.

Copy this link into your browser window:

http://badges.cet.edu' . $badgeCriteria . '

You can download the file that opens using File - Save As - 

' . $badgeName . ' Certificate

The above URL is TOP SECRET. Please do not share it.

Please DO show off you certificate, and share how you earned it!

We think you will enjoy the other NASA activities mentioned at the bottom of the certificate.

Great job on this challenge!

Badge Team at the Center for Educational Technologies
Home of the NASA-sponsored Classroom of the Future
http://badges.cet.edu
';
		} else {
			$subject = "Your " . $badgeName . " Badge";
			$message = 'Congratulations!

You have successfully completed the ' . $badgeName . ' activity and earned a badge.

To retrieve your badge, click or copy this link into your browser window (Google Chrome and Mozilla Firefox work best):

' . $getMyBadgeURL . '

To view your certificate, click on the badge, then on the Criteria link in your backpack.

Please DO show off your certificate, and share how you earned it!

Badge Team at the Center for Educational Technologies
Home of the NASA-sponsored Classroom of the Future
http://badges.cet.edu
';
	}
		$headers = "To: " . $to . "\r\n";
		$headers .= "From: " . $from . "\r\n";
		//$headers .= "Bcc: ruckman@cet.edu\r\n";

		if(mail($to, $subject, $message, $headers)) {
			$successes .= "<div>" . $to . "</div>";
		} else {
			$errors .= "<div>" . $to . "</div>";
		}
		if(strrpos($successes, "@") <= 0)
			$successes = "";
		if(strrpos($errors, "@") <= 0)
			$errors = "";
	}
		//Save badges earned data

		$agegroup = $_POST["rbDesc"];

		$badgeName = $_GET["badge"];

		$sql = "INSERT INTO `awardslog` (`badgename`, `agegroup`)
				VALUES ('$thebadge', '$agegroup')";

		$dbhost = 'db2.cet.edu';
		$dbuser = 'andrew';
		$dbpass = '54mur41';
		$dbname = 'badges';

		$link = mysql_connect($dbhost, $dbuser, $dbpass);
		mysql_select_db($dbname);

		mysql_query($sql) or die(mysql_error());

		mysql_close($link);

		//Set return messages
		
		$returndata = array(
		'posted_form_data' => array(
			'badgeId' => $badgeId,
			'badgeRecipient' => $badgeRecipientName,
			'badgeRecipientEmail' => $badgeRecipientEmail,
			'badgeExperienceUrl' => $badgeExperienceURL
			),
		'success' => $msg,
		'errors' => $err
	);
	
	//go back to Gadget Badger page with results
	
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){
		
		//set session variables & return success or errors
		session_start();
		$_SESSION['bf_returndata'] = $returndata;
		$_SESSION["mailResult"] = $successes."\n".$errors;
		
		//redirect back to form
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
	
}
?>