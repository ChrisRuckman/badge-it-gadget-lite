<?php

//Badge-It Gadget Lite v0.5.0 - Simple scripted system to award and issue badges into Mozilla Open Badges Infrastructure
//Copyright (c) 2012 Kerri Lemoie, Codery - gocodery.com
//Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php

/*** 

This is the settings file for Badge-It Gadget Lite 

Read more about Open Badges Assertions here: https://github.com/mozilla/openbadges/wiki/Assertions 

***/

/* Issuer API url - REQUIRED. This is Open Badge's hosted issuer API. */

$open_badges_api = "http://beta.openbadges.org/issuer.js";

/*version - REQUIRED. Use "0.5.0" for the beta. */

$version = "0.5.0";

/*issuer url - REQUIRED. This is the domain name of the site that will be issuing the badges. It should be the domain where you're installing the OpenBadgifier.*/

$issuer_url = "http://badges.cet.edu";

/*root path - REQUIRED. CHMOD 775. This is the root path of where your process-badges directory is hosted. You SHOULD password protect this directory with something like .htaccess so that the public can't issue badges on your behalf. */

/*NOTE: your server may require the path to be: $root_path = $_SERVER['DOCUMENT_ROOT']."/badge-it-gadget-lite/process-badges/"; (Notice forward slash before "badge-it-gadget-lite" */

$root_path = $_SERVER['DOCUMENT_ROOT']."/badge-it-gadget-lite/process-badges/";

/* issuer name  - REQUIRED. name of organization or person that is issuing the badges. */

$issuer_name = "Badges for NASA Activities"; //This appears on the badge

/*issuer org - OPTIONAL. Organization for which the badge is being issued. Another example is if a scout badge is being issued, the "name" could be "Boy Scouts" and the "org" could be "Troop #218". */

$issuer_org = "Center for Educational Technology at Wheeling Jesuit University, Home of the NASA-Sponsored Classroom of the Future";

/* issuer contact - OPTIONAL. A human-monitored email address associated with the issuer. */

$issuer_contact = "badges@cet.edu";

/* JSON file directory - REQUIRED. CHMOD 777. OpenBadgifier generates JSON file for each issued badge (per person). The JSON files need to be in a publicly accessible but not obvious directory. This should start at the document root of your host. Note that example has slashes at the end of the path. Please be sure to include. */

/*NOTE: your server may require the path to be: $json_dir = $_SERVER['DOCUMENT_ROOT']."/badge-it-gadget-lite/digital-badges/issued/json/"; (Notice forward slash before "badge-it-gadget-lite" */

$json_dir = $_SERVER['DOCUMENT_ROOT']."/badge-it-gadget-lite/digital-badges/issued/json/";

/* badge images directory - REQUIRED. Set the path to the directory where your badge images are stored. They should be stored on the same domain as OpenBadifier since the images should be on the issuing site. Don't have badge images yet? You can mae some here (note: they must be PNG) - http://www.onlineiconmaker.com/application/ */

$badge_images_dir = "/badge-it-gadget-lite/digital-badges/images/";

/* badge records file - REQUIRED. CHMOD 777. OpenBadgifier will keep records in a text file of which badges were issued and if they were pushed to the obi. This could easily be extended to use a db later. Nice to have a lightweight solution anyone can use. This file has already been created and is in the directory where this settings file is.*/

$badge_records_file = "badge_records.txt";

/* BADGES!! - this is the array to store badges data. 

info on how to learn about arrays in php: http://devzone.zend.com/8/php-101-part-4-the-food-factor/ 

Here are the values (all REQUIRED unless noted otherwise):

name = The name of your badge. Example "Badge-It Gadget Lite Badgee" (max 128 characters)
image = The filename of the image. Example "badge-it-gadget-lite.png". This image should be in your $badge_images_dir. (Badge must be a .png) 
description = "Short text describing the badge. Example "Earner is ready to award badges with Badget-It Gadget Lite.". (max 128 characters)
criteria_url =  Relative URL describing the badge and criteria for earning the badge. It should be on the same server as Badge-It Gadget Lite. If you keep the directory structure as is, you can just change the .html file name in the example.
expires = OPTIONAL. Date when the badge expires. If omitted, the badge never expires. Format: YYYY-MM-DD

Notice there is a number and an array of values for each badge. The example below has two badges.
*/

$badges_array = array(
	1 => array(
		"name" => "Lunar Rover Geometry", 
		"image" => "LunarRoverGeometryBadge.png", 
		"description" => "Learners apply their knowledge of the rate formula and Pythagorean theorem to a space exploration challenge", 
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/LunarRoverGeometryCertificate.pdf"),
	2 => array(
		"name" => "RWIW RealWorld Team",
		"image" => "RealWorldTeamBadge.png",
		"description" => "Modeling, teamwork, engineering skills applied to solve challenge: research & redesign a mirror/sunshield for a Space Telescope",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/RealWorldTeamCertificate.pdf"),
	3 => array(
		"name" => "RWIW RealWorld Coach",
		"image" => "RWIWRealWorldCoachBadge.png",
		"description" => "Time management/engineering skills applied to lead team to solve a Space Telescope mirror/sunshield redesign challenge",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/RWCoachCertificate.pdf"),
	4 => array(
		"name" => "RWIW InWorld Team",
		"image" => "InWorldTeamBadge.png",
		"description" => "Modeling/teamwork/engineering/programming skills applied to present Space Telescope mirror/sunshield design in virtual world",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/InWorldTeamCertificate.pdf"),
	5 => array(
		"name" => "RWIW InWorld Mentor",
		"image" => "InWorldMentorBadge.png",
		"description" => "Virtual world/engineering skills applied to lead team to present and improve NASA Space Telescope design in virtual world",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/RWIWInWorldMentorCertificate.pdf"),
	6 => array(
		"name" => "RWIW InWorld Top 5 Teams",
		"image" => "RWIWInWorldTop5TeamBadge.png",
		"description" => "Advanced modeling/engineering/programming skills applied to present Space Telescope mirror/sunshield design in virtual world",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/RWIWInWorldTop5Certificate.pdf"),
	7 => array(
		"name" => "RWIW InWorld Champion Team",
		"image" => "InWorldTeamChampion.png",
		"description" => "Advanced modeling/engineering/programming skills applied to present Space Telescope mirror/sunshield in virtual world",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/InWorldTeamChampionCertificate.pdf"),
	8 => array(
		"name" => "RWIW InWorld Evaluator Badge",
		"image" => "RWIWInWorldEvaluatorBadge.png",
		"description" => "Skillfully/diplomatically used rubric to observe/question/evaluate virtual world Space Telescope design in virtual world tours",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/RWIWInWorldEvaluatorCertificate.pdf"),
	9 => array(
		"name" => "Flight Areodynamics/Shoebox Glider Challenge",
		"image" => "FlightDynamicsShoeboxGliderBadge.png",
		"description" => "After NASA aerodynamics videoconference, apply skill to design/test a shoebox glider; present results in second videoconference",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/FlightDynamicsShoeboxGliderCertificate.pdf"),
	10 => array(
		"name" => "Making Waves - Electromagnetic Spectrum",
		"image" => "MakingWavesBadge.png",
		"description" => "Order/model/share research electromagnetic spectrum & apply to Fermi Gamma Ray Telescope; calculate wavelength/frequency",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/MakingWavesCertificate.pdf"),
	11 => array(
		"name" => "Global Temperatures-Exploring the Environment",
		"image" => "ETEGlobalTemperaturesBadge.png",
		"description" => "Analyze global temperature data sets; describe trends/impacts; propose strategy to lessen impacts & perform pros/cons analysis",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/ETEGlobalTemperaturesCertificate.pdf"),
	12 => array(
		"name" => "CyGaMEs - Lunar Geology - Three Star",
		"image" => "CyGaMEsSelene3-StarBadge.png",
		"description" => "Finish Selene game and correctly discover and apply the lunar and planetary geology concepts of heat, mass, and radiation",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/CyGaMEsSelene3-StarCertificate.pdf"),
	13 => array(
		"name" => "CyGaMEs - Lunar Geology - Seven Star",
		"image" => "",
		"description" => "Discover and apply all sevenSelene lunar and planetary geology concepts replicating 4.5 billion years of lunar history",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/"),
	14 => array(
		"name" => "Mars Curiosity Design Challenge",
		"image" => "MarsCuriosity_Design.png",
		"description" => "Learners apply engineering design to create or redesign a mobile robot model of the Curiosity rover and submit documentation",
		"criteria_url" => "/badge-it-gadget-lite/digital-badges/images/MarsCuriosity_Design.pdf"),
	);