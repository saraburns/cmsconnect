<?php
/* coaches.php
Produces a list of options containing the current coaches in the database */
	require_once("MDB2.php");
	require_once("/home/cs304/public_html/php/MDB2-functions.php");
	require_once("cmsconnect-dsn.inc"); 

		//connect to the db and return a db handle
	$dbh = db_connect($cmsconnect_dsn);

	$result = query($dbh, "select bnumber, identifier from humans where status='coach'");
	while($r = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$bnumber = $r['bnumber'];
		$identifier = $r['identifier'];
		echo "<option value=$bnumber>$identifier</option>";

	}

?>