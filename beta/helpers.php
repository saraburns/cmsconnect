<?php
//helpers.php
//Contains various helper functions


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
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					// Additional headers
					$headers .= 'From: Chamber Music Society <cms@example.com>' . "\r\n";
					mail($member_emails,$subject, $message, $headers);
				}
				
			

?>