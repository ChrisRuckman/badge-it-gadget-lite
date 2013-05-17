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

/*This script is called by the OpenBadges.issue callback to record issued badges*/

	include '../process-badges/gadget-settings.php';

	$date = date('Y-m-d');

	//Write badge to badge_records.txt file
	$badgeRecordsFile = $root_path . $badge_records_file;
	
	$badgeHandle = fopen($badgeRecordsFile, 'a'); 
	$badge_data = "BADGE ISSUED: ".$date.", ".$_POST['data']."\n";
	
	if (fwrite($badgeHandle, $badge_data) === FALSE) {
		$err .= '<div class="badge-error">Cannot write to file (".$badgeRecordsFile."). Please check your $root and $badge_records_file in gadget_settings.php</div>';
	}
	
	fclose($badgeHandle);
	
?>	