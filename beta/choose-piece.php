<?php
/* choose-piece.php
Displays pieces in the db which match the instrumentation provided exactly. */
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("cmsconnect-dsn.inc");

//connect to the db and return a db handle
$dbh = db_connect($cmsconnect_dsn);
$script = $_SERVER['PHP_SELF'];
$instruments = explode(";", $_POST['instruments']);

//finds pieces which match the instrumentation provided exactly
function findPieces($instrts){
	global $dbh;
	$pieces_array = array();
	$list_string = "(";
	$index = 0;
	$heading = "Pieces for ";
	foreach($instrts as $i){
		$heading = $heading.$i;
		$list_string = $list_string."'".$i."'";
		if ($index != count($instrts) - 1){
		 $list_string = $list_string.",";
		 $heading = $heading.", ";
		}
		$index += 1;
	}
	$instrt_list= array_replace(array_fill(0,5,null), $instrts);
	$length = count($instrts);
	$pieces = "select * from instrumentation inner join pieces using (pid) 
	where instrument in (?,?,?,?,?) group by pid having count(*) = ? and num_inst = ?";
	$pieces_query = prepared_query($dbh,$pieces,array($instrt_list[0], $instrt_list[1], $instrt_list[2], $instrt_list[3], 
		$instrt_list[4], $length, $length));

	while($piece = $pieces_query->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$pid = $piece['pid'];
		$title = $piece['title'];
		$composer = $piece['composer'];
		$pieces_array[$pid] = array();
		array_push($pieces_array[$pid], $title, $composer);
	}
	echo "<h4>".$heading;
	return $pieces_array;
}
//formats pieces in a radio button list
function formatPieces($pieces_array){
	$formatted =  "<ul>";
	$i = 0;
	foreach($pieces_array as $pid=>$piece){
		$title = $piece[0];
		$composer = $piece[1];
		if($i > 0){
			$formatted = $formatted."
    		<input type='radio' class ='select-piece' name='options' id='$pid'><h5>$composer<h5><h6>$title</h6></input>";
  		}else{
  			$formatted = $formatted."
   			 <input type='radio' name='options' id='$pid' class = 'select-piece' checked><h5>$composer<h5><h6>$title</h6></input>";	
  		}
  	$i++;
	}
	$formatted = $formatted."</ul>";



	return $formatted;

}

echo "<h3>Now, pick a piece.";
echo formatPieces(findPieces($instruments));

?>