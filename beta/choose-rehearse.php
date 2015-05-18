<?php

/*choose-rehearse.php
Sara Burns and Shelley Wang
Displays an interface for users to select from compatible times in their schedules. */
//get members and coaching time from the ajax request

	//$members = explode(";", $_POST['members']);
	//$cTime = $_POST['coaching_time'];
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    require_once("MDB2.php");
	require_once("/home/cs304/public_html/php/MDB2-functions.php");
	require_once("cmsconnect-dsn.inc");

	$dbh = db_connect($cmsconnect_dsn);

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
	//connect to the db and return a db handle
	$members = array();
	$sql = "SELECT bnumber FROM members WHERE groupid=(SELECT groupid FROM members WHERE bnumber=?)";
	$values = array($bnumber);
	$resultset = prepared_query($dbh,$sql,$values);
	//Get user's bnumber
	while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$members[] = $row['bnumber'];
		//echo "array_values($members)";
	}
	foreach ($members as $item) {
    echo $item;
}
	function findCompatible($people){
	global $dbh;
	$times= array();
	$list_string = "(";
	$index = 0;
	$heading = "Compatible Rehearsal Times\n";
	foreach($people as $i){
		$list_string = $list_string."'".$i."'";
		if ($index != count($people) - 1){
		 $list_string = $list_string.",";
		}
		$index += 1;
	}
	$list_string = $list_string.")";
	$length = binCoef(count($people));
	echo $length;
	//does not yet remove coaching time from the results
	$compatible = "select * from schedule inner join schedule as s1 using (timeid) where s1.bnumber in $list_string
	and schedule.bnumber in $list_string and s1.bnumber > schedule.bnumber group by timeid having count(*) = ?";
	//there was no way to insert ths list using a prepared query
	//we figured the security risk was minor, since the field is not input by the user
	$compatible_query = prepared_query($dbh,$compatible,array($length));

	while($time = $compatible_query->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$tid = $time['timeid'];
		$times[$tid] = makePretty($tid);
	}
	echo "<h4>".$heading;
	return $times;
}
//converts time ids to human readable days and times
function makePretty($t){
		$pretty_days = array("Sunday", "Monday ", "Tuesday ", "Wednesday ", "Thursday ", "Friday ", "Saturday ");
		$pretty_times = array("7 AM", "8 AM", "9 AM", "10 AM", "11 AM", "12 PM", "1 PM", "2 PM", "3 PM", "4 PM",
		 "5 PM", "6 PM", "7 PM", "8 PM", "9 PM", "10 PM");
		$day = $pretty_days[(int)substr($t,0,1)];
		$time = $pretty_times[(int)substr($t,1)];
		return $day.$time;
	}

	//calculates the factorial of a given value n
function factorial($n){
	if ($n < 2 ){
		return 1;
	}else{
		return ($n * factorial($n-1));
	}

}

//calculates the binomial coefficient (n choose 2) of a given value n
function binCoef($n){
	return factorial($n) / (factorial($n-2)*2);

}
//formats the availalble times as an unordered list
function formatPieces($pieces_array){
	$formatted =  "<ul>";
	$i = 0;
	foreach($pieces_array as $tid=>$time){
		if($i > 0){
		$formatted = $formatted."<p>
    <input type='radio' name='roptions' id='$tid' class = 'select-rtime' autocomplete='off'><h5>$time</input>";
  	}else{
  		$formatted = $formatted."
    <p><input type='radio' name='roptions' id='$tid' class = 'select-rtime' autocomplete='off' checked><h5>$time</input>";	
  	}
  	$i++;
	}
	$formatted = $formatted."</ul>";
	return $formatted;

}
echo "<h3>Finally, pick a rehearsal time.";
echo formatPieces(findCompatible($members));
?>