<?php
//helpers.php
//Contains various helper functions


//times values range for 000 to 615
	$pretty_days = array("Sunday", "Monday ", "Tuesday ", "Wednesday ", "Thursday ", "Friday ", "Saturday ");
	
	$pretty_times = array("7 AM", "8 AM", "9 AM", "10 AM", "11 AM", "12 PM", "1 PM", "2 PM", "3 PM", "4 PM",
		 "5 PM", "6 PM", "7 PM", "8 PM", "9 PM", "10 PM");

		//takes a list of ids and converts them to human readable day/times
	function makePretty($time_list){
		global $pretty_days, $pretty_times;
		$formatted_times = array();
		foreach($time_list as $t){
			$day = $pretty_days[(int)substr($t,0,1)];
			$time = $pretty_times[(int)substr($t,1)];
			array_push($formatted_times,$day.$time);
		}
		return $formatted_times;
	}

	//alerts the new members they have been added to a group	
			function sendEmailtoGroup($members, $subject, $message){
				global $dbh;
				$member_emails = "";
				$i = 0;
				foreach($members as $m){
					$email_query = "SELECT email from humans where bnumber = ?";
					$email = prepared_query($dbh, $email_query, array($m));
					while($em=$email->fetchRow(MDB2_FETCHMODE_ASSOC)){
						if($i > 0){
						$member_emails = $member_emails.", ".$em['email'];
					}else{
						$member_emails = $em['email'];
					}
						$i++;
				}
					}
					
					mail($member_emails,$subject, $message, $headers);
				}
				
			

?>