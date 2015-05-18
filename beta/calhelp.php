<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
// require("session.php");
require_once("MDB2.php");
//require_once("calhelp.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("cmsconnect-dsn.inc");

//connect to the db and return a db handle




$dbh = db_connect($cmsconnect_dsn);
$email = $_SESSION['email'];
//$email;
$bnumber;
if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$values = array($email);
	// Query to display title & release year of movie
	$sql = "SELECT bnumber FROM humans where email=?";
	$resultset = prepared_query($dbh,$sql,$values);
	//Get user's bnumber
	while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$bnumber = $row['bnumber'];
	}
}


// if (isset($_POST['name']) || isset($_POST['location'])){
// 	$namey = $_POST['name'];
// 	$location = $_POST['location'];
// 	echo "<p>$namey is the name, $location is the place";

// }

if (isset($_POST['notfree'])){
	$timeid = $_POST['notfree'];
	//echo "<p>$timeid is the time slot we want to add in";
	$dupeValues = array($bnumber, $timeid);
	$sql = "SELECT bnumber,timeid FROM schedule WHERE bnumber=? AND timeid=?";
	$resultset = prepared_query($dbh,$sql,$dupeValues);
	//echo "Wasn't free before";
	// variable to compute numRows
	$nr = $resultset->numRows();
	//if scheduled free time already in database, return error message
	if ($nr >= 1) {
		// compactDisplay($resultset,'nm');
		//error message here

	} else {
		// Else insert the new timeslot associated with the user into the table
		$sql = "INSERT INTO schedule VALUES (?,?)";
		$data = array($bnumber,$timeid);
		prepared_statement($dbh,$sql,$data);
	}

}

if (isset($_POST['inschedule'])){
	$timeid = $_POST['inschedule'];
	$sql = "DELETE FROM schedule WHERE bnumber=? AND timeid=?";
	$data = array($bnumber,$timeid);
	prepared_statement($dbh,$sql,$data);

}



$freeTimeArray = array(); //array to hold the timeid's of all the user's free time slots
	$sql = "SELECT timeid FROM schedule where bnumber=?";
	$values = array($bnumber);
	$resultset = prepared_query($dbh,$sql,$values);
	//Push all of the current entered user schedule data into an array called $freeTimeArray
	while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$freeTimeArray[] = $row['timeid'];
	}

	//Query for meeting time's timeID
	$sql = "SELECT meetingtime FROM groups where groupid=(SELECT groupid FROM members WHERE bnumber=?)";
	//The array of values to be used in the prepared value is the same as in the previous query (both use the user's bnumber)
	$resultset = prepared_query($dbh,$sql,$values);
	$nr = $resultset->numRows();
	if ($nr >= 1){
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$meetingtime = $row['meetingtime'];
		}
	}else{
		$meetingtime = 999;
	}

	//Query for rehearsal time's timeID
	$sql = "SELECT rehearsaltime FROM groups where groupid=(SELECT groupid FROM members WHERE bnumber=?)";
	//The array of values to be used in the prepared value is the same as in the previous query (both use the user's bnumber)
	$resultset = prepared_query($dbh,$sql,$values);
	$nr = $resultset->numRows();
	if ($nr >= 1){
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$rehearsaltime = $row['rehearsaltime'];
		}
	}else{
		$rehearsaltime = 999;
	}

		//	echo "Meeting time is ".$meetingtime.", Rehearsal time is ".$rehearsaltime;

	$starttime = 7;
	$endtime = 8;
	$ampm = 'AM';
	$timenum;
	//default time slot status
	$slotstatus = 'notfree';

	//Set up the "header" of the table (days of the week, Sunday-Saturday)
	echo "<table class='table table-bordered table-condensed' id='table1'>\n
		<tr>\n
		<td class='datenames'></td>
		<td class='datenames'>Sun</td>
		<td class='datenames'>Mon</td>
		<td class='datenames'>Tues</td>
		<td class='datenames'>Wednes</td>
		<td class='datenames'>Thurs</td>
		<td class='datenames'>Fri</td>
		<td class='datenames'>Sat</td>
		</tr>\n";

	for ($timenumhelp = 0;$timenumhelp<=15;$timenumhelp++) {
		if($timenumhelp <= 9){
			//Prepend a zero to the $timenumhelp so that the $timenum will be two digits no matter what
			//$timenum will be used to help construct the timeids that will be inserted into the database
			$timenum="0".$timenumhelp;
		}else{
			$timenum=$timenumhelp;
		}

	    echo "<tr>\n
	    	<td class='timerange'>$starttime-$endtime$ampm</td>\n";
    	//increase the Start time and End time of the slots for the next row time slot labels
    	$starttime++;
    	$endtime++;
    	//Once the ending time of the slots becomes 12 (12 PM), change the am/pm status to 'PM' for the rest of the time range column
    	if ($endtime == 12){
    		$ampm='PM';
    	}
    	//When the starting time in the range is incremented to the "13th hour," change it so that it will be "1" (PM)
    	if ($starttime == 13){
    		$starttime=1;
    	}
    	//When the ending time in the range is incremented to the "13th hour," change it so that it will be "1" (PM)
    	if ($endtime == 13){
    		$endtime=1;
    	}

	    for ($colnum=0;$colnum<=6;$colnum++){
	    	$timeid=$colnum.$timenum;
	    	//check timeid against array of current times, meetingtime, or rehearsal time to set $slotstatus to the appropriate class
	    	for($i=0; $i<count($freeTimeArray) ; $i++){
	    		if ($timeid == $freeTimeArray[$i]){
	    			$slotstatus = 'inschedule';
	    		}
	    		if ($timeid == $meetingtime){
	    			$slotstatus = 'meeting';
	    		}
	    		if ($timeid == $rehearsaltime){
	    			$slotstatus = 'rehearsal';
	    		}
	    	}
	            echo "  <td class='$slotstatus' id='$timeid' name='pie'>".$timeid."</td>";

	            //Reset slot status to default (not free)
	            $slotstatus = 'notfree';
	        }

	    echo "</tr>\n";
	}

	echo "</table>\n";


?>
