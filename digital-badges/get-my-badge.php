<?php

//Badge-It Gadget Lite v0.5.0 - Simple scripted system to award and issue badges into Mozilla Open Badges Infrastructure
//Copyright (c) 2012 Kerri Lemoie, Codery - gocodery.com
//Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php

/*
* -----------------------------------------------------------------------
*
* Modified by Center for Educational Technologies
* Copyright (c) 2013 Center for Educational Technologies
* Sublicensed under the GNU GPL license
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
* -----------------------------------------------------------------------
*/

/* This script retrieves/issues the badge for the badge earner */

include '../process-badges/gadget-settings.php';

//retrieves the badge info based on the id passed in the get string

$badge = str_rot13($_GET[id]);
preg_match('/\d*/', $badge, $matches);
$badgeId = $matches[0];
preg_match('/\D+/', $badge, $matches);
$recipient_name = preg_replace('/-|_/',' ',$matches[0]);

?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Get My Badge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get My Badge">
    <meta name="author" content="">

		<link rel="stylesheet" href="../css/style.css">
	  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->	
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script src="<?php print $open_badges_api; ?>"></script>

<script>
$(document).ready(function() {
	
	$('.js-required').hide();
	
	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){  //The Issuer API isn't supported on MSIE Bbrowsers
		$('.backPackLink').hide();
		$('.login-info').hide();
		$('.browserSupport').show();
	}
	
	//Function that issues the badge
	
	$('.backPackLink').click(function() {
		//you may need to adjust the assertion URL based on where you store your json files
		
		var assertionUrl = "<?php print $issuer_url; ?>/badge-it-gadget-lite/digital-badges/issued/json/<?php print $_GET[id]; ?>.json";
       OpenBadges.issue([''+assertionUrl+''], function(errors, successes) { 
				//	alert(errors.toSource()) 
				//	alert(successes.toSource()) 
					if (errors.length > 0 ) {
						$('#errMsg').text('Error Message: '+ errors.toSource());
						$('#badge-error').show();	
						var data = 'ERROR, <?php echo $badges_array[$badgeId]['name']; ?>, <?php echo $recipient_name; ?>, ' +  errors.toSource();
						$.ajax({
    					url: 'record-issued-badges.php',
    					type: 'POST',
    					data: { data: data }
						});
					}
					
					if (successes.length > 0) {
							$('.backPackLink').hide();
							$('.login-info').hide();
							$('#badgeSuccess').show();
							var data = 'SUCCESS, <?php echo $badges_array[$badgeId]['name']; ?>, <?php echo $recipient_name; ?>';
							$.ajax({
    						url: 'record-issued-badges.php',
    						type: 'POST',
    						data: { data: data }
							});
						}	
					});    
				});
	});
</script>


  </head>

  <body>
	<div class="light-bg-container">
		<header>
    		<h1><a href="http://badges.cet.edu">Badges for <img src="images/NASA-2Color.png" style="width: 72px;" alt="NASA" /> Activities</a></h1>
		</header>
		<section id="badge-container">
			<div class="js-required">Javascript is required to get your badge. Please enable it in your preferences.</div>
			<ul class="criteria-no-style">
				<li>Badge Name: <?php echo $badges_array[$badgeId]['name']; ?></li>
				<li>Badge Earner: <?php echo $recipient_name; ?></li>
				<li>
					<div class="backPackLink">Click here to get your badge!</div> 
					<div class="browserSupport">(Please use Firefox or Chrome to retrieve your badge)</div>
					<span class="login-info">(You will be asked to login or sign in to create a backpack. Please use the email address your badge link was sent to.)</span>
				</li>
				<li><div id="badge-error"><p><em>Hmmmm...something went wrong.</em> <span id="errMsg"></span></div></li>
				<li>
					<div id="badgeSuccess"><p><em>Congratulations!</em> If you ever want to manage or view your badges, just visit your <a href="http://beta.openbadges.org/" target="_blank">Open Badges backpack</a></p>
				</div>
			</li>
		</ul>
		</section>
</div>


  </body>
</html>
