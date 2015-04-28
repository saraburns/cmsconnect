<?php 
//These files provides us the credentials and methods to work with our mysql database via MDB2
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("cmsconnect-dsn.inc");

//connect to the db and return a db handle
$dbh = db_connect($cmsconnect_dsn);
$script = $_SERVER['PHP_SELF'];
$coach_query = "SELECT identifier from humans where bnumber = (SELECT coach from groups where groupid = ?)";

function populateList($category){
	global $dbh, $coach_query, $script;
	$listcontents = "";
	$list_query = "";
	if($category == "groups"){
		$list_query = "SELECT composer, currentgroup from pieces where currentgroup is not null";
		$resultset = query($dbh, $list_query);
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    		$composer = $row['composer'];
    		$currentgroup = $row['currentgroup'];
    		$coach_result = prepared_query($dbh, $coach_query, array($currentgroup));
    		$coach_row = $coach_result->fetchRow(MDB2_FETCHMODE_ASSOC);
    		$coach_name = $coach_row['identifier']; 
    		$listcontents = $listcontents . "<a href='http://cs.wellesley.edu/~cmsconnect/cmsconnect/admin.php?groupid=$currentgroup' class='list-group-item'>$composer: $coach_name</a>";
 		}
 	}else if($category == "people"){
 		$person_query = "SELECT identifier,bnumber from humans";
 		$people_result = query($dbh, $person_query);
		while($row = $people_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
			$identifier = $row['identifier'];
			$bnumber = $row['bnumber'];
			$listcontents = $listcontents . "<a href='http://cs.wellesley.edu/~cmsconnect/cmsconnect/admin.php?bnumber=$bnumber' class='list-group-item'>$identifier</a>";					
		}
	}else if($category == "pieces") {
		$piece_query = "SELECT composer, title,pid from pieces";
		$piece_result = query($dbh,$piece_query);
		while($row = $piece_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
			$composer = $row['composer'];
			$title = $row['title'];
			$pid = $row['pid'];
			$listcontents = $listcontents . "<a href='http://cs.wellesley.edu/~cmsconnect/cmsconnect/admin.php?pid=$pid' class='list-group-item'>$composer: $title</a>";					
		}
	}



 	

 		return $listcontents;

}
if(isset($_REQUEST['category'])) echo populateList($_REQUEST['category']);

?>